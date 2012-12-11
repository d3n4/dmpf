<?
    /**
     * Database entry model
     */
    Interface IModel {
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

        /**
         * Save or Update Model
         */
        Public Function save();
    }