<?
    
    /**
     * Database driver
     */
    Class Driver Implements IDriver {
        
        /**
         * Driver
         * @var IDriver Driver
         */
        Protected $Driver = null;
        
        /**
         * Instance of driver
         * @var Driver instance of driver 
         */
        Protected Static $_Driver;
        
        /**
         * Set new database driver
         * @param IDriver $Driver
         */
        Public Function __construct(IDriver $Driver = null){
            $this->Driver = $Driver;
        }
        
        /**
         * Set Driver
         * @param IDriver $Driver
         */
        Public Static Function Set(IDriver $Driver){
            self::$_Driver = new self($Driver);
        }
        
        /**
         * Get Instance of current driver
         * @return IDriver driver
         */
        Public Static Function Get(){
            return self::$_Driver;
        }
        
        Public Function SetConnectData($Host, $Username, $Password, $Database) {
            return $this->Driver->SetConnectData($Host, $Username, $Password, $Database);
        }
        
        Public Function Connected() {
            return $this->Driver->Connected();
        }
        
        Public Function setDriver(IDriver $Driver){
            $this->Driver = $Driver;
        }
        
        Public Function getDriver(){
            return $this->Driver;
        }
        
        Public Function Connect() {
           return $this->Driver->Connect();
        }
        
        Public Function Disconnect() {
           return $this->Driver->Disconnect();
        }
        
        Public Function Insert( $Object, $Table ){
            return $this->Driver->Insert($Object, $Table);
        }
        
        Public Function Select( $Query, $Table ){
            return $this->Driver->Select($Query, $Table);
        }
        
        Public Function Delete( $Query, $Table ){
            return $this->Driver->Delete($Query, $Table);
        }
        
        Public Function Update( $Object, $Query, $Table ){
            return $this->Driver->Update($Object, $Query, $Table);
        }
        
        Public Function Truncate( $Table ){
            return $this->Driver->Truncate($Table);
        }
    }