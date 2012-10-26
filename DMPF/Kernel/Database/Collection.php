<?
    Class Collection implements ICollection {
        
        Protected Static $m_Collections = Array();
        Protected $m_Colleciton;
        
        Public Function __construct($Collection) {
            $this->m_Colleciton = $Collection;
        }
        
        /**
         * Get collection by name
         * @param ICollection $Collection collection name
         */
        Public Static Function Get($Collection){
            IF(isset(self::$m_Collections[$Collection]))
                return self::$m_Collections[$Collection];
            self::$m_Collections[$Collection] = new Collection($Collection);
            return self::$m_Collections[$Collection];
        }
        
        /**
         * Insert object into collection
         * @param array|object $Object
         * @return boolean Result
         */
        Public Function Insert($Object) {
            return Driver::Get()->Insert($this->m_Colleciton, $Object);
        }
        
        /**
         * Select object from collection
         * @param IQuery $Query
         * @return array|IModel Result
         */
        Public Function Select(IQuery $Query) {
            return Driver::Get()->Select($this->m_Colleciton, $Query);
        }
        
        /**
         * Delete object from collection
         * @param IQuery $Query
         * @return boolean Result
         */
        Public Function Delete(IQuery $Query) {
            return Driver::Get()->Delete($this->m_Colleciton, $Query);
        }
        
        /**
         * Update object in collection
         * @param array|object $Object
         * @param IQuery $Query
         * @return boolean Result
         */
        Public Function Update($Object, IQuery $Query) {
            return Driver::Get()->Update($this->m_Colleciton, $Object, $Query);
        }        
        
        /**
         * Truncate collection
         * @return boolean Result
         */
        Public Function Truncate() {
            return Driver::Get()->Truncate($this->m_Colleciton);
        }
        
        /**
         * Count items in collection
         * @return integer Count items in collection
         */
        Public Function Count() {
            return Driver::Get()->Count($this->m_Colleciton);
        }
    }