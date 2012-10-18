<?

    /**
     * Application bootstrap
     */
    Abstract Class Application {
        /**
         * Boot Framework
         * @return bool Framework boot result
         */
        Public Static Function Boot($ActionResult){
            IF($ActionResult){
                $ResultString = $ActionResult->getResult();
                echo $ResultString;
                return true;
            }
            ELSE throw new RouteNotFoundException('Route for url "'.Router::$Uri.'" not found.');
        }
    }