<?
    /**
     * Router
     */
    Class Router Extends Properties {
        Public Static $Uri;
        Protected $m_Routes;
        Public Function __construct() {
            
            $devConf = Config::Read('developer');
            IF($devConf['autoRouter'])
                self::Generate();
            
            ForEach( (Array) file( ROUTES_FILE ) As $RouteString ){
                $RouteString = trim($RouteString);
                IF(strlen($RouteString)>0)
                {
                    IF($RouteString[0] != '#' && $RouteString[0] != ';'){
                        $RoutesArray = explode(' ', $RouteString);
                        $RouteArray = Array();
                        ForEach( (Array) $RoutesArray As $RouteData )
                            IF(strlen(trim($RouteData)) > 0)
                                $RouteArray[] = $RouteData;
                        IF(sizeof($RouteArray) >= 3){
                            $Method = trim(strtoupper($RouteArray[0]));
                            IF($Method == 'GET')
                                $Method = Route::GET;
                            ELSEIF($Method == 'POST')
                                $Method = Route::POST;
                            ELSEIF($Method == '*')
                                $Method = Route::ALL;
                            $Uri = $RouteArray[1];
                            IF(!String::endWith('/', $Uri))
                                String::Append ('/', $Uri);
                            IF(!String::startWith('/', $Uri))
                                String::Prepend ('/', $Uri);
                            $ConAct = explode('.', $RouteArray[2], 2);
                            IF(sizeof($ConAct) >= 2){
                                $Controller = trim($ConAct[0]);
                                $Action = trim($ConAct[1]);
                            }
                            
                            $this->m_Routes[] = new Route($Method, $Uri, $Controller, $Action);
                        }
                    }
                }
            }
        }
        
        /**
         * Generate routes file
         */
        Public Static Function Generate(){
            $Routes = '';
            ForEach( (Array) glob(APPLICATION_DIR.'/Controllers/*.php') As $ControllerFile )
            {
                $ControllerContent = file_get_contents($ControllerFile);
                $ControllerNames = array();
                preg_match_all('/class\s(.*)\s/Uis', $ControllerContent, $ControllerNames);
                IF(!isset($ControllerNames[1]))
                   return;
                IF(!isset($ControllerNames[1][0]))
                    return;
                $ControllerName = $ControllerNames[1][0];
                $ControllerRoutes = array();
                preg_match_all('/#\s(GET|POST|\*)\s(.+)\s#\s(.*)Function ([a-zA-Z0-9\_]+)[\(]/Uis', $ControllerContent, $ControllerRoutes);
                String::Append("# ".$ControllerName." Controller\r\n", $Routes);
                ForEach( (Array) Converter::pma2Array($ControllerRoutes) As $Route )
                    IF(sizeof($Route) > 0)
                        String::Append(String::Format("{0} {1} {2}.{3}\r\n", $Route[1], $Route[2], $ControllerName, $Route[4]), $Routes);
                String::Append("\r\n", $Routes);
            }
            file_put_contents(ROUTES_FILE, $Routes);
        }
        
        /**
         * Get Instance of router class
         * @return Router Instance of Router class
         */
        Public Static Function Instance(){
            return new Router;
        }
        
        /**
         * Call router action by route
         * @param IRoute $Route route
         * @param array $Arguments arguments
         * @return bool Action result
         */
        Public Function CallByRoute(IRoute $Route, $Arguments = Array()){
            return self::Call($Route->getController(), $Arguments);
        }
        
        /**
         * Call router action by name
         * @param string $Controller controller name
         * @param array $Arguments arguments
         * @return bool Action result
         */
        Public Static Function Call($Controller, $Arguments = Array()){
            $Controller = explode('.', $Controller);
            $ctrl = new $Controller[0]();
            $callback = Array( $ctrl, $Controller[1] );
            IF(is_callable($callback)){
                call_user_func_array ($callback, $Arguments);
                return true;
            }
            return false;
        }
        
        /**
         * Proceed router uri
         * @return bool Proceed result
         */
        Public Function Proceed(){
            return $this->ProceedEx($_GET['uri']);
        }
        
        /**
         * Proceed router uri
         * @param string $uri
         * @return bool Proceed result
         */
        Public Function ProceedEx($uri){
            $Route = $this->Find($uri);
            self::$Uri = String::CutRight($uri, 1);
            IF($Route){
                $arguments = array();
                preg_match_all('|'.$Route->Uri.'|Uis', $uri, $arguments);
                IF(isset($arguments[1]))
                    $arguments = $arguments[1];
                return $this->CallByRoute ($Route, $arguments);
            }
            return false;
        }
        
        /**
         * Find route by uri
         * @param string $Uri
         * @return Route|null Route 
         */
        Public Function Find($Uri){
            return $this->FindEx($Uri, $_SERVER['REQUEST_METHOD']);
        }
        
        /**
         * Find route by uri and method
         * @param string $Uri
         * @param string $Method
         * @return Route|null Route
         */
        Public Function FindEx($Uri, $Method){
            IF(!String::endWith('/', $Uri))
                String::Append ('/', $Uri);
            IF(!String::startWith('/', $Uri))
                String::Prepend ('/', $Uri);
            ForEach( (Array) $this->m_Routes As $Route )
                IF( $Route->Method == $Method || $Route->Method == Route::ALL ){
                    $arguments = array();
                    preg_match_all('|'.$Route->Uri.'|Uis', $Uri, $arguments);
                    IF(isset($arguments[0]))
                        IF(isset($arguments[0][0]))
                            return $Route;
                }
            return null;
        }
    }