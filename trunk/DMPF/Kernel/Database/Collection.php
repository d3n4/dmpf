<?
    Class Collection implements ICollection {
        
        Protected Static $m_Collections = Array();
        Protected $m_Collection;
        Protected $m_Type;
        
        Public Function __construct($Collection, $Type = 'Model') {
            $this->m_Collection = $Collection;
            $this->m_Type = $Type;
        }
        
        /**
         * Get collection by name
         * @param string $Collection collection name
         * @param string $Type model type
         * @return ICollection
         */
        Public Static Function Get($Collection, $Type = 'Model'){
            IF(isset(self::$m_Collections[$Collection]))
                return self::$m_Collections[$Collection];
            self::$m_Collections[$Collection] = new Collection($Collection, $Type);
            return self::$m_Collections[$Collection];
        }
        
        /**
         * Insert object into collection
         * @param array|object $Object
         * @return boolean Result
         */
        Public Function Insert($Object) {
            return Driver::Get()->Insert($this->m_Collection, $Object);
        }
        
        /**
         * Select object from collection
         * @param IQuery $Query
         * @return Model[] Result
         */
        Public Function Select(IQuery $Query) {
            return Driver::Get()->Select($this->m_Collection, $Query, $this->m_Type);
        }
        
        /**
         * Find object from collection
         * @param IQuery $Query
         * @return Model[] Result
         */
        Public Function Find(IQuery $Query) {
            return Driver::Get()->Select($this->m_Collection, $Query, $this->m_Type);
        }
        
        /**
         * Delete object from collection
         * @param IQuery $Query
         * @return boolean Result
         */
        Public Function Delete(IQuery $Query) {
            return Driver::Get()->Delete($this->m_Collection, $Query);
        }
        
        /**
         * Update object in collection
         * @param array|object $Object
         * @param IQuery $Query
         * @return boolean Result
         */
        Public Function Update($Object, IQuery $Query) {
            return Driver::Get()->Update($this->m_Collection, $Object, $Query);
        }        
        
        /**
         * Truncate collection
         * @return boolean Result
         */
        Public Function Truncate() {
            return Driver::Get()->Truncate($this->m_Collection);
        }
        
        /**
         * Count items in collection
         * @return integer Count items in collection
         */
        Public Function Count() {
            return Driver::Get()->Count($this->m_Collection);
        }
    }