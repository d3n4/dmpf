<? 
    Interface IQuery {
        
        /**
         * Get object
         * @return array|object object
         */
        Public Function getObject();
        
        /**
         * Get fields
         * @return array fields
         */
        Public Function getFields();
        
        /**
         * Get one
         * @return bool one
         */
        Public Function getOne();
        
        /**
         * Get Limit
         * @return int limit
         */
        Public Function getLimit();
        
        /**
         * Get consitions
         * @return array|ICondition contidions
         */
        Public Function getConditions();
        
        /**
         * Get offset
         * @return int offset
         */
        Public Function getOffset();
        
        /**
         * Set fields
         * @param array|string $Fields
         * @return IQuery self
         */
        Public Function setFields($Fields);
        
        /**
         * Set one
         * @param bool $One
         * @return IQuery self
         */
        Public Function setOne($One);
        
        /**
         * Set Limit
         * @param int $Limit
         * @return IQuery self
         */
        Public Function setLimit($Limit);
        
        /**
         * Set conditions
         * @param array|ICondition $Conditions
         * @return IQuery self
         */
        Public Function setConditions($Conditions);
        
        /**
         * Set offset
         * @param int $Offset
         * @return IQuery self
         */
        Public Function setOffset($Offset);
        
        /**
         * Set object
         * @param array|object $Object
         */
        Public Function setObject($Object);
    }