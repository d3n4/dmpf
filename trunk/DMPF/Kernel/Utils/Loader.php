<?
    namespace DMPF\Utils
    {
        Class Loader
        {
            Protected Static $Index = Array();
            
            Public Static Function index($path){
                $this->Index[trim($path)] = true;
            }
            
            Public Static Function deindex($path){
                unset($this->Index[trim($path)]);
            }
            
            Public Static Function indexed($path){
                return isset($this->Index[trim($path)]);
            }
            
            Public Static Function Load($path){
                throw new \Exception('Not Implemented');
            }
            
            Public Static Function Register(){
                spl_autoload_register('DMPF\Utils\Loader::Load');
            }
            
            Public Static Function unRegister(){
                spl_autoload_unregister('DMPF\Utils\Loader::Load');
            }
        }
        
        Loader::Register();
    }