<?

    /**
     * Database driver interface
     */

    Interface IDriver {
        
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