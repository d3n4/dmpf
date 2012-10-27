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
         * @param string $Table table name
         * @param object|array $Object Object to serialize
         */
        Public Function Insert( $Table, $Object );
        
        /**
         * Select entry from table
         * @param string $Table table name
         * @param object|array $Query
         * @return mixed result
         */
        Public Function Select( $Table, IQuery $Query, $Type = 'Model' );
        
        /**
         * Find entry in table
         * @param string $Table table name
         * @param object|array $Query
         * @return mixed result
         */
        Public Function Find( $Table, IQuery $Query, $Type = 'Model' );
        
        /**
         * Delete entry from table
         * @param string $Table table name
         * @param object|array $Query
         */
        Public Function Delete( $Table, IQuery $Query );
        
        /**
         * Update entry in table
         * @param string $Table table name
         * @param object|array $Object
         * @param object|array $Query
         */
        Public Function Update( $Table, $Object, IQuery $Query );
        
        /**
         * Truncate table
         * @param string $Table table name
         */
        Public Function Truncate( $Table );
        
        /**
         * Get count of items in table
         * @param string $Table table name
         * @return integer Count
         */
        Public Function Count( $Table );
    }