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
         * Set new database driver
         * @param IDriver $Driver
         */
        Public Function __construct(IDriver $Driver = null){
            $this->Driver = $Driver;
        }
        
        Public Function setDriver(IDriver $Driver){
            $this->Driver = $Driver;
        }
        
        Public Function getDriver(){
            return $this->Driver;
        }
        
        Public Function Insert( $Object, $Table ){
            $this->Driver->Insert($Object, $Table);
        }
        
        Public Function Select( $Query, $Table ){
            $this->Driver->Select($Query, $Table);
        }
        
        Public Function Delete( $Query, $Table ){
            $this->Driver->Delete($Query, $Table);
        }
        
        Public Function Update( $Object, $Query, $Table ){
            $this->Driver->Update($Object, $Query, $Table);
        }
        
        Public Function Truncate( $Table ){
            $this->Driver->Truncate($Table);
        }
    }