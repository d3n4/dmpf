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
        
        Public Function Insert( $Table, $Object ){
            return $this->Driver->Insert($Table, $Object);
        }
        
        Public Function Select( $Table, IQuery $Query, $Type = 'Model' ){
            return $this->Driver->Find($Table, $Query, $Type);
        }
        
        Public Function Find( $Table, IQuery $Query, $Type = 'Model' ){
            return $this->Driver->Find($Table, $Query, $Type);
        }
        
        Public Function Delete( $Table, IQuery $Query ){
            return $this->Driver->Delete($Table, $Query);
        }
        
        Public Function Update( $Table, $Object, IQuery $Query ){
            return $this->Driver->Update($Table, $Object, $Query);
        }
        
        Public Function Truncate( $Table ){
            return $this->Driver->Truncate($Table);
        }
        
        Public Function Count( $Table ){
            return $this->Driver->Count($Table);
        }
    }