<?

    /**
     * Database driver interface
     */

    Interface IDriver {
        
        /**
         * Set connection information
         * @param string $Host database host/address
         * @param string $Username username
         * @param string $Password password
         * @param string $Database database name
         */
        Public Function SetConnectData($Host, $Username, $Password, $Database);
        
        /**
         * @return bool connect result
         */
        Public Function Connect();
        
        /**
         * Disconnect
         */
        Public Function Disconnect();
        
        /**
         * Is connected to the server
         * @return bool result
         */
        Public Function Connected();
        
        /**
         * Insert object into table
         * @param object|array $Object Object to serialize
         * @param string $Table table name
         */
        Public Function Insert( $Object, $Table );
        
        /**
         * Select entry from table
         * @param object|array $Query
         * @param string $Table table name
         * @return mixed result
         */
        Public Function Select( $Query, $Table );
        
        /**
         * Delete entry from table
         * @param object|array $Query
         * @param string $Table table name
         */
        Public Function Delete( $Query, $Table );
        
        /**
         * Update entry in table
         * @param object|array $Object
         * @param object|array $Query
         * @param string $Table table name
         */
        Public Function Update( $Object, $Query, $Table );
        
        /**
         * Truncate table
         * @param string $Table table name
         */
        Public Function Truncate( $Table );
    }