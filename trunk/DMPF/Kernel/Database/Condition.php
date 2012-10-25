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
        
        Public Static Function Equal(){
            
        }
        
        Public Static Function Lower(){
            
        }
    }