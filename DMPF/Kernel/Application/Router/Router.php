<?
    /**
     * Router
     */
    Class Router Extends Properties {
        Public Static $Uri;
        Public Static $Controller;
        Public Static $ControllerName;
        Public Static $Action;
        Protected $m_Routes;
        Public Function __construct() {
            IF(Config::Read('developer', 'autoRouter', false))
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
                            IF(!String::endWith('/', $Uri) || strlen($Uri) == 1)
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
            Stopwatch::Create(__CLASS__.'::'.__FUNCTION__);
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
                Loader::alias($ControllerName, $ControllerFile);
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
                $ActionResult = call_user_func_array ($callback, $Arguments);
                IF(Config::Read('display', 'clean', false))
                    ob_end_clean();
                return $ActionResult;
            }
            return false;
        }
        
        /**
         * Proceed router uri
         * @return bool Proceed result
         */
        Public Function Proceed(){
            $uri = $_REQUEST['uri'];
            unset($_REQUEST['uri']);
            return $this->ProceedEx($uri);
        }
        
        /**
         * Proceed router uri
         * @param string $uri
         * @return bool Proceed result
         */
        Public Function ProceedEx($uri){
            Stopwatch::Create(__CLASS__.'::'.__FUNCTION__);
            self::$Uri = '/'.$uri;//String::CutRight($uri, 1);
            $Route = $this->Find($uri);
            IF($Route){
                self::$Controller = $Route->getController();
                self::$ControllerName = $Route->getControllerName();
                self::$Action = $Route->getAction();
                $arguments = array();
                preg_match_all('|'.$Route->Uri.'|Uis', $uri, $arguments);
                $arguments_x = array();
                $argId = 1;
                $argCount = sizeof($arguments);
                For($argId; $argId < $argCount; $argId++)
                    IF(isset($arguments[$argId][0]))
                        $arguments_x[] = $arguments[$argId][0];
                return $this->CallByRoute ($Route, $arguments_x);
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
            //IF(String::endWith('/', $Uri))
                //$Uri = String::CutRight ($Uri, 1);
            $Uri = '[/'.$Uri.'/]';
            IF(!String::endWith('/', $Uri))
                String::Append ('/', $Uri);
            IF(!String::startWith('/', $Uri))
                String::Prepend ('/', $Uri);
            ForEach( (Array) $this->m_Routes As $Route )
                IF( $Route->Method == $Method || $Route->Method == Route::ALL ){
                    $arguments = array();
                    preg_match_all('|\['.$Route->Uri.'\]|Uis', $Uri, $arguments);
                    IF(isset($arguments[0]))
                        IF(isset($arguments[0][0]))
                            return $Route;
                }
            return null;
        }
    }