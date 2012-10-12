<?
    /**
     * Framework bootstrap
     */

    Abstract Class Bootstrap
    {
        /**
         * Boot Framework
         * @return bool Framework boot result
         */
        
        Public Static Function Boot(){
            IF(!Router::Instance()->Proceed()){
                throw new RouteNotFoundException('Route for url "'.$_GET['uri'].'" not found.');
                return false;
            }
            return true;
        }
    }