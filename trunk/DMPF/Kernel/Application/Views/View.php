<?
    Class View extends Properties implements IView {
        Protected $m_Id;
        Protected $m_Template;
        Protected $m_Filename;
        Protected $m_ViewModel;
        Protected $m_Variables = Array();
        Public Function getId(){ return $this->m_Id; }
        Public Function getTemplate(){ return $this->m_Template; }
        Public Function getFilename(){ return $this->m_Filename; }
        Public Function getViewModel(){ return $this->m_ViewModel; }
        Public Function getVariables(){ return $this->m_Variables; }
        
        Public Function __construct($template = null){
            $this->Load($template);
        }
        
        Public Function Set($Key, $Value = null){
            $this->m_Variables[$Key] = $Value;
        }
        
        Public Function Get($Key){
            IF(isset($this->m_Variables[$Key]))
                return $this->m_Variables[$Key];
            return null;
        }
        
        Public Function Put($Variables){
            $this->m_Variables = $Variables;
            return $this;
        }
        
        Public Static Function Instance($template = null){
            return new View($template);
        }
        
        Public Static Function Render($template, $Variables = array()){
            return View::Instance($template)->Put($Variables)->Compile();
        }
        
        Public Function Load($template){
            IF($template === null) return;
            $this->m_Id = strtoupper(md5(microtime(1).rand(0,100000)));
            $this->m_Template = $template;
            $this->m_Filename = APPLICATION_DIR . '/Views/' . $this->m_Template;
            IF(file_exists($this->m_Filename)){
                
            }
            ELSE throw new TemplateNotFound('Template "'.$this->m_Template.'" not found.');
        }
        
        Public Function Compile(){
            $ViewModel_Class = String::Format('ViewModel_{0}', $this->m_Id);
            @eval( String::Format('Class {0} extends ViewModel implements IViewModel { Public Function Render(){extract($this->get()); $self = $this->get(); ob_start(); ?>{1}<? $buf = ob_get_contents(); ob_end_clean(); return $buf;} }', $ViewModel_Class, file_get_contents($this->m_Filename) ) );
            IF(!class_exists($ViewModel_Class)){
                $err = error_get_last();
                ExceptionHandler::SimulateError ($err['type'], 'template ' . $err['message'], $this->m_Filename, $err['line']);
            }
            $this->m_ViewModel = new $ViewModel_Class();
            return $this->m_ViewModel->set($this->m_Variables)->Render();
        }
    }