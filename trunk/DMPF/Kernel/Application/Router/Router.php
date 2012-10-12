<?
    /**
     * Router
     */
    Class Router Extends Properties {
        Protected $m_Routes;
        Public Function __construct() {
            ForEach( (Array) file( APPLICATIONS.'/'.APPLICATION.'/Routes' ) As $RouteString ){
                IF(strlen(trim($RouteString))>0)
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
         * Get Instance of router class
         * @return Router Instance of Router class
         */
        Public Static Function Instance(){
            return new Router;
        }
        
        /**
         * Call router action
         * @param Route $Route
         * @param array $Arguments
         */
        Public Function Call(Route $Route, $Arguments){
            $Controller = new $Route->Controller();
            $callback = Array( $Controller, $Route->Action );
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
            IF($Route){
                $arguments = array();
                preg_match_all('|'.$Route->Uri.'|Uis', $uri, $arguments);
                IF(isset($arguments[1]))
                    $arguments = $arguments[1];
                return $this->Call ($Route, $arguments);
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