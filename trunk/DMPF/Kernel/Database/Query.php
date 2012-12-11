<?
    DEFINE ( 'Query_AND', '&&' );
    DEFINE ( 'Query_OR', '||' );
    
    Class EmptyQuery Implements IQuery {
        Public Function getConditions() {}
        Public Function getFields() {}
        Public Function getLimit() {}
        Public Function getObject() {}
        Public Function getUpdateObject() {}
        Public Function getOffset() {}
        Public Function getOne() {}
        Public Function getJoiner() {}
        Public Function setConditions($Conditions) {}
        Public Function setFields($Fields) {}
        Public Function setLimit($Limit) {}
        Public Function setObject($Object) {}
        Public Function setUpdateObject($Object) {}
        Public Function setOffset($Offset) {}
        Public Function setOne($One) {}
        Public Function setJoiner($Joiner) {}
    }
    
    Class Query extends Properties implements IQuery {
        
        Protected Static $None = null;
        
        Protected $m_Fields;
        Protected $m_Conditions = Array();
        Protected $m_Limit;
        Protected $m_Offset;
        Protected $m_One;
        Protected $m_Object;
        Protected $m_UpdateObject;
        Protected $m_Joiner = Query_AND;
        
        Public Function getFields() {
            return $this->m_Fields;
        }
        
        Public Function getConditions() {
            return $this->m_Conditions;
        }
        
        Public Function getFrom() {
            return $this->m_From;
        }
        
        Public Function getLimit() {
            return $this->m_Limit;
        }
        
        Public Function getOffset() {
            return $this->m_Offset;
        }
        
        Public Function getOne() {
            return $this->m_One;
        }
        
        Public Function getObject() {
            return $this->m_Object;
        }

        Public Function getUpdateObject() {
            return $this->m_UpdateObject;
        }

        Public Function getJoiner() {
            return $this->m_Joiner;
        }
        
        Public Function setFields($Fields) {
            $this->m_Fields = $Fields;
            return $this;
        }
        
        Public Function setConditions($Conditions) {
            $this->m_Conditions = $Conditions;
            return $this;
        }
        
        Public Function setFrom($From) {
            $this->m_From = $From;
            return $this;
        }
        
        Public Function setLimit($Limit) {
            $this->m_Limit = $Limit;
            return $this;
        }
        
        Public Function setOffset($Offset) {
            $this->m_Offset = $Offset;
            return $this;
        }
        
        Public Function setOne($One) {
            $this->m_One = $One;
            return $this;
        }
        
        Public Function setObject($Object) {
            $this->m_Object = $Object;
            return $this;
        }

        Public Function setUpdateObject($Object) {
            $this->m_UpdateObject = $Object;
            return $this;
        }

        Public Function setJoiner($Join) {
            $this->m_Joiner = $Join;
            return $this;
        }

        Public Function __construct($Conditions = array(), $Fields = null, $Limit = null, $Offset = null, $One = false, $Joiner = Query_AND){
            $this->m_Fields = $Fields;
            $this->m_Conditions = $Conditions;
            $this->m_Limit = $Limit;
            $this->m_Offset = $Offset;
            $this->m_One = $One;
            $this->m_Joiner = $Joiner;
        }
        
        
        
        /**
         * Empty query
         * @return EmptyQuery
         */
        Public Static Function None(){
            IF(!self::$None)
                self::$None = new EmptyQuery();
            return self::$None;
        }
        
        /**
         * Instance of object
         * @return Query query
         */
        Public Static Function Instance(){
            return new self();
        }
        
        /**
         * Get query instance by object
         * @param array|object $Object object
         * @return Query query
         */
        Public Static Function Object($Object){
            $Query = new self();
            $Query->setObject($Object);
            return $Query;
        }

        /**
         * Get query instance by UpdateObject
         * @param array|object $Object object
         * @return Query query
         */
        Public Static Function UpdateObject($Object){
            $Query = new self();
            $Query->setUpdateObject($Object);
            return $Query;
        }
        
        /**
         * All queries
         * @return IQuery self
         */
        Public Static Function All(){
            $Queries = func_get_args();
            IF(isset($Queries[0]))
                IF(gettype($Queries[0]) === 'array')
                    $Queries = $Queries[0];
            
            $m_Conditions = Array();
            $m_Fields = Array();
            $m_Limit = null;
            $m_Offset = null;
            $m_One = false;
            $m_UpdateObject = null;
            $m_Object = null;
            $m_Joiner = null;


            /* @var $Query IQuery */
            ForEach($Queries As $Query){
                IF(is_array($Query->getConditions()))
                    $m_Conditions = array_merge($m_Conditions, $Query->getConditions());
                ELSE
                    $m_Conditions[] = $Query->getConditions();
                IF(is_string($Query->getFields()))
                    $m_Fields[] = $Query->getFields();
                ELSE IF(is_array($Query->getFields()))
                    $m_Fields = array_merge ($m_Fields, $Query->getFields());
                IF($Query->getLimit() !== null)
                    $m_Limit = $Query->getLimit();
                IF($Query->getOffset() !== null)
                    $m_Offset = $Query->getOffset();
                IF($Query->getOne() !== null)
                    $m_One = $Query->getOne();
                IF($Query->getOne() !== null)
                    $m_One = $Query->getOne();
                IF($Query->getObject() !== null)
                    $m_Object = $Query->getObject();
                IF($Query->getUpdateObject() !== null)
                    $m_UpdateObject = $Query->getUpdateObject();
                IF($Query->getJoiner() !== null)
                    $m_Joiner = $Query->getJoiner();
            }
            $query = new self($m_Conditions, $m_Fields, $m_Limit, $m_Offset, $m_One);
            return $query->setObject($m_Object)->setUpdateObject($m_UpdateObject)->setJoiner($m_Joiner);
        }

        /**
         * All queries with AND
         * @return IQuery self
         */

        Public Static Function iAnd(){
            return self::All(func_get_args())->setJoiner(Query_AND);
        }

        /**
         * All queries with OR
         * @return IQuery self
         */

        Public Static Function iOr(){
            return self::All(func_get_args())->setJoiner(Query_OR);
        }
        
        /**
         * @param string $A Key
         * @param string $B Value
         * @param string $Type
         * @return ICondition condition
         */
        Public Static Function Equal( $A, $B ){
            return new Query(Condition::Equal($A, $B));
        }
        
        /**
         * @param string $A Key
         * @param string $B Value
         * @param string $Type
         * @return ICondition condition
         */        
        Public Static Function NotEqual( $A, $B ){
            return new Query(Condition::NotEqual($A, $B ));
        }
        
        /**
         * @param string $A Key
         * @param string $B Value
         * @param string $Type
         * @return ICondition condition
         */
        Public Static Function Lower( $A, $B ){
            return new Query(Condition::Lower($A, $B));
        }
        
        /**
         * @param string $A Key
         * @param string $B Value
         * @param string $Type
         * @return ICondition condition
         */
        Public Static Function LowerOrEqual( $A, $B ){
            return new Query(Condition::LowerOrEqual($A, $B));
        }
        
        /**
         * @param string $A Key
         * @param string $B Value
         * @param string $Type
         * @return ICondition condition
         */
        Public Static Function Greater( $A, $B ){
            return new Query(Condition::Greater($A, $B));
        }
        
        /**
         * @param string $A Key
         * @param string $B Value
         * @param string $Type
         * @return ICondition condition
         */
        Public Static Function GreaterOrEqual( $A, $B ){
            return new Query(Condition::GreaterOrEqual($A, $B));
        }
    }