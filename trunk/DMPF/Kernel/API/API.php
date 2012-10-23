<?
    /**
     * API Engine
     */
    Abstract Class API {
        
        Const ErrorNotFoundModule = 0,
              ErrorNotFoundAction = 1;
        
        /**
         * Is API initialized
         * @var bool Initialized 
         */
        Protected Static $Initialized = false;
        
        /**
         * Modules list
         * @var array modules
         */
        Protected Static $Modules = Array();
        
        /**
         * Initialize API
         */
        Public Static Function Initialize(){
            self::$Initialized = true;
            IF(Config::Read('api', 'connectAll', true))
                    ForEach( (Array) glob(APPLICATION_DIR.'/API/*.php') As $API_Module ){
                        $ModuleName = basename($API_Module, '.php');
                        self::addModule ( new $ModuleName );
                    }
        }
        
        /**
         * Register module in API
         * @param string $Module module instance
         * @throws InvalidModuleTypeException
         */
        Public Static Function addModule($Module){
            $ModuleName = get_class($Module);
            IF(!is_subclass_of($Module, 'Module'))
                    throw new InvalidModuleTypeException('Invalid type of module "'.$ModuleName.'"');
            self::$Modules[strtolower($ModuleName)] = $Module;
        }
        
        
        /**
         * Try to get module by module name
         * @param string $ModuleName module name
         * @return null|Module module
         */
        Public Static Function getModule($ModuleName){
            IF(isset(self::$Modules[strtolower($ModuleName)]))
                return self::$Modules[strtolower($ModuleName)];
            return null;
        }
        
        /**
         * Call API action
         * @param string $ModuleName module name
         * @param string $ActionName action name
         * @param array $Arguments arguments
         * @return array API response
         */
        Public Static Function Call( $ModuleName, $ActionName, $Arguments ){
            IF(!self::$Initialized)
                self::Initialize ();
            $ApiResponse = Array('Response' => false);
            $Response = false;
            $Module = self::getModule($ModuleName);
            IF($Module !== null && is_object($Module)){
                IF(is_callable(Array($Module, $ActionName)))
                    $Response = @call_user_func_array (Array($Module, $ActionName), $Arguments);
                ELSE
                    $ApiResponse['Error'] = Array('Code' => self::ErrorNotFoundAction, 'Description' => 'Module action not found');
            }
            ELSE
                $ApiResponse['Error'] = Array('Code' => self::ErrorNotFoundModule, 'Description' => 'Module not found');
            $ApiResponse['Response'] = $Response;
            return $ApiResponse;
        }
    }