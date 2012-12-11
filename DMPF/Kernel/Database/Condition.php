<?
    Class Condition extends Properties implements ICondition {
        Protected $m_Key;
        Protected $m_Operator;
        Protected $m_Value;

        Public Function getKey() {
            return $this->m_Key;
        }
        
        Public Function getOperator() {
            return $this->m_Operator;
        }
        
        Public Function getValue() {
            return $this->m_Value;
        }
        
        Public Function __construct( $Key, $Operator, $Value ) {
            $this->m_Key = $Key;
            $this->m_Operator = $Operator;
            $this->m_Value = $Value;
        }
        
        /**
         * @param string $A Key
         * @param string $B Value
         * @return ICondition condition
         */
        Public Static Function Equal( $A, $B ){
            return new self( $A, '=', $B );
        }
        
        /**
         * @param string $A Key
         * @param string $B Value
         * @return ICondition condition
         */
        Public Static Function NotEqual( $A, $B ){
            return new self( $A, '!=', $B );
        }
        
        /**
         * @param string $A Key
         * @param string $B Value
         * @return ICondition condition
         */
        Public Static Function Lower( $A, $B ){
            return new self( $A, '<', $B );
        }
        
        /**
         * @param string $A Key
         * @param string $B Value
         * @return ICondition condition
         */
        Public Static Function Greater( $A, $B ){
            return new self( $A, '>', $B );
        }
        
        /**
         * @param string $A Key
         * @param string $B Value
         * @return ICondition condition
         */
        Public Static Function LowerOrEqual( $A, $B ){
            return new self( $A, '<=', $B );
        }
        
        /**
         * @param string $A Key
         * @param string $B Value
         * @return ICondition condition
         */
        Public Static Function GreaterOrEqual( $A, $B ){
            return new self( $A, '>=', $B );
        }
    }