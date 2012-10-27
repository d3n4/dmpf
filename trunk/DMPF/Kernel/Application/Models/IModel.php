<?
    /**
     * Database entry model
     */
    Interface IModel {
        /**
         * Assign properties from object/array
         * @param array|object $Object
         * @return IModel self
         */
        Public Function Assign($Object);
        
        /**
         * Get value of model by key
         * @param string $Key
         * @return mixed Value
         */
        Public Function Get($Key);
        
        /**
         * Set value of model by key
         * @param string $Key
         * @param mixed $Value
         * @return IModel Model
         */
        Public Function Set($Key, $Value);
    }