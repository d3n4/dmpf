<?
    Class Condition extends Properties implements ICondition {
        Protected $m_Key;
        Protected $m_Operator;
        Protected $m_Value;
        Protected $m_Type;
        
        Public Function getKey() {
            return $this->m_Key;
        }
        
        Public Function getOperator() {
            return $this->m_Operator;
        }
        
        Public Function getValue() {
            return $this->m_Value;
        }
        
        Public Function getType() {
            return $this->m_Type;
        }
        
        Public Function __construct( $Key, $Operator, $Value, $Type = Query_AND ) {
            $this->m_Key = $Key;
            $this->m_Operator = $Operator;
            $this->m_Value = $Value;
            $this->m_Type = $Type;
        }
        
        /**
         * @param string $A Key
         * @param string $B Value
         * @param string $Type
         * @return ICondition condition
         */
        Public Static Function Equal( $A, $B, $Type = Query_AND ){
            return new self( $A, '=', $B, $Type );
        }
        
        /**
         * @param string $A Key
         * @param string $B Value
         * @param string $Type
         * @return ICondition condition
         */
        Public Static Function NotEqual( $A, $B, $Type = Query_AND ){
            return new self( $A, '!=', $B, $Type );
        }
        
        /**
         * @param string $A Key
         * @param string $B Value
         * @param string $Type
         * @return ICondition condition
         */
        Public Static Function Lower( $A, $B, $Type = Query_AND ){
            return new self( $A, '<', $B, $Type );
        }
        
        /**
         * @param string $A Key
         * @param string $B Value
         * @param string $Type
         * @return ICondition condition
         */
        Public Static Function Greater( $A, $B, $Type = Query_AND ){
            return new self( $A, '>', $B, $Type );
        }
        
        /**
         * @param string $A Key
         * @param string $B Value
         * @param string $Type
         * @return ICondition condition
         */
        Public Static Function LowerOrEqual( $A, $B, $Type = Query_AND ){
            return new self( $A, '<=', $B, $Type );
        }
        
        /**
         * @param string $A Key
         * @param string $B Value
         * @param string $Type
         * @return ICondition condition
         */
        Public Static Function GreaterOrEqual( $A, $B, $Type = Query_AND ){
            return new self( $A, '>=', $B, $Type );
        }
    }