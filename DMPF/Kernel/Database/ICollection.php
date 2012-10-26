<?

    /**
     * Collection interface
     */

    Interface ICollection {
        /**
         * Insert object into collection
         * @param object|array $Object Object to serialize
         */
        Public Function Insert( $Object );
        
        /**
         * Select entry from collection
         * @param object|array $Query
         * @return mixed result
         */
        Public Function Select( IQuery $Query );
        
        /**
         * Delete entry from collection
         * @param object|array $Query
         */
        Public Function Delete( IQuery $Query );
        
        /**
         * Update entry in collection
         * @param object|array $Object
         * @param object|array $Query
         */
        Public Function Update( $Object, IQuery $Query );
        
        /**
         * Truncate collection
         */
        Public Function Truncate();
        
        /**
         * Get count of items in collection
         * @return integer Count
         */
        Public Function Count();
    }