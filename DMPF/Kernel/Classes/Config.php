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
         * @param string $Section Section
         * @param string $Key Key
         * @return mixed Value
         */
        Public Static Function Read($Section, $Key, $defaultValue = null){
            IF(isset(self::$Memory[$Section]))
                IF(isset(self::$Memory[$Section][$Key]))
                    return self::$Memory[$Section][$Key];
            return $defaultValue;
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