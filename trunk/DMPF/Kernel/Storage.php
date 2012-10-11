<?
    /**
     * Framework objects storage
     */
    Abstract Class Storage {
        
        /**
         * Objects storage
         * @var Array Storage
         */
        Protected Static $Storage = Array();
        
        /**
         * Save element in storage
         * @param string $Key
         * @param mixed $Value
         */
        Public Static Function set($Key, $Value){
            self::$Storage[$Key] = $Value;
        }
        
        /**
         * Load element from storage
         * @param string $Key
         * @return mixed Element
         */
        Public Static Function get($Key){
            return self::$Storage[$Key];
        }
    }