<?
    /**
     * Config helper
     */
    Abstract Class Config {
        /**
         *  Config memory
         * @var Array Memory cell
         */
        Protected Static $Memory;
        
        /**
         * Read section variables
         * @param string $Key Section key
         * @return stdClass Variables
         */
        Public Static Function Read($Key){
            return self::$Memory[$Key];
        }
        
        Public Static Function ReadObject($Key){
            return Converter::ArrayToObject(self::$Memory[$Key]);
        }
        
        /**
         * Load configuration from file
         * @param string $Filename configuration file name
         */
        Public Static Function Load( $Filename ){
            self::$Memory = parse_ini_file($Filename, true);
        }
    }