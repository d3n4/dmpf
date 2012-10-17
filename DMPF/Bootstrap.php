<?

    /**
     * Framework bootstrap
     */
    Abstract Class Bootstrap {        
        /**
         * Boot Framework
         * @return bool Framework boot result
         */
        Public Static Function Boot(){
            IF(Application::Boot(Router::Instance()->Proceed()))
                return true;
            return false;
        }
    }