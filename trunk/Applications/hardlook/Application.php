<?

    /**
     * Application bootstrap
     */
    Abstract Class Application {
        /**
         * Boot Framework
         * @return bool Framework boot result
         */
        Public Static Function Boot($Success){
            IF(!$Success)
                throw new RouteNotFoundException('Route for url "'.Router::$Uri.'" not found.');
            return true;
        }
    }