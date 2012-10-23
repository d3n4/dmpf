<?
    /**
     * Template view
     */
    Class View extends Properties implements IView, IActionResult {
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
        
        /**
         * Set view variable
         * @param string $Key variable key
         * @param mixed $Value variable value
         * @return View
         */
        Public Function Set($Key, $Value = null){
            $this->m_Variables[$Key] = $Value;
            return $this;
        }
        
        /**
         * Get variable from view
         * @param type $Key variable key
         * @return mixed variable value
         */
        Public Function Get($Key){
            IF(isset($this->m_Variables[$Key]))
                return $this->m_Variables[$Key];
            return null;
        }
        
        /**
         * Extract variables from array/ViewModel
         * @param array|ViewModel $data
         * @return View
         */
        Public Function Put($data){
            IF(gettype($data) == 'array')
                $this->m_Variables = $data;
            ELSE IF(is_subclass_of($data, 'ViewModel'))
                $this->m_Variables = $data->get();
            return $this;
        }
        
        /**
         * Get instance of View
         * @param string $template
         * @return View
         */
        Public Static Function Instance($template = null){
            return new View($template);
        }
        
        /**
         * Render template
         * @param string $template template name
         * @param array|ViewModel $Variables variables to restore
         * @return View
         */
        Public Static Function Render($template, $Variables = array()){
            Stopwatch::Create(__CLASS__.'::'.__FUNCTION__);
            return View::Instance($template)->Put($Variables)->Compile();
        }
        
        /**
         * Load template
         * @param string $template template name
         * @throws TemplateNotFound
         */
        Public Function Load($template){
            Stopwatch::Create(__CLASS__.'::'.__FUNCTION__);
            IF($template === null) return;
            $this->m_Id = strtoupper(md5(microtime(1).rand(0,100000)));
            $this->m_Template = $template;
            $this->m_Filename = APPLICATION_DIR . '/Views/' . $this->m_Template;
            IF(!file_exists($this->m_Filename))
                throw new TemplateNotFound('View template "'.$this->m_Template.'" not found.');
        }
        
        /**
         * Compile template
         * @return string compiled content
         */
        Public Function Compile(){
            Stopwatch::Create(__CLASS__.'::'.__FUNCTION__);
            $ViewModel_Class = String::Format('ViewModel_{0}', $this->m_Id);
            $View = file_get_contents($this->m_Filename);
            $View = str_replace( Array('{%','%}'), Array('<?','?>'), $View );
            @eval( String::Format('Class {0} extends ViewModel implements IViewModel { Public Function Render(){extract($this->get()); $self = $this->get(); ob_start(); ?>{1}<? $buf = ob_get_contents(); ob_end_clean(); return $buf;} }', $ViewModel_Class, $View ) );
            IF(!class_exists($ViewModel_Class)){
                $err = error_get_last();
                ExceptionHandler::SimulateError ($err['type'], 'template ' . $err['message'], $this->m_Filename, $err['line']);
            }
            $this->m_ViewModel = new $ViewModel_Class();
            return $this->m_ViewModel->set($this->m_Variables)->Render();
        }
        
        /**
         * Get ActionResult
         * @return string
         */
        Public Function getResult(){
            Stopwatch::Create(__CLASS__.'::'.__FUNCTION__);
            return $this->Compile();
        }
    }