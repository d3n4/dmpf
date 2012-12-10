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
            IF($ActionResult && is_object($ActionResult) && ($Reflection=new ReflectionClass($ActionResult)) && $Reflection->implementsInterface('IActionResult')){
                $ResultString = $ActionResult->getResult();
                echo $ResultString;
                return true;
            }
            ELSE IF( $ActionResult === false ) throw new RouteNotFoundException('Route for url '.Router::$Uri.' not found.');
            ELSE
                throw new ActionResultException('Controller action '. Router::$Controller . ' not return ActionResult.');
        }
    }