<?
    Interface ICondition {
        
        /**
         * Get key of condition
         * @return string Key
         */
        Public Function getKey();
        
        /**
         * Get operator of condition
         * @return string Operator
         */
        Public Function getOperator();
        
        /**
         * Get value of condition
         * @return string Value
         */
        Public Function getValue();
    }