<?
    /**
     * Result from controller action
     */
    Class ActionResult extends Properties implements IActionResult {
        Protected $m_Result;
        Protected $m_Type;
        Protected $m_Class;
        Public Function __construct($Result) {
            $this->m_Result = $Result;
            $this->m_Type = gettype($this->m_Result);
            IF($this->m_Type == 'object')
                $this->m_Class = get_class($this->m_Result);
        }
        
        Public Function getResult() {
            IF( $this->m_Type == 'string' )
                return $this->m_Result;
            ELSE IF( $this->m_Type == 'array' )
                return implode('', $this->m_Result);
            ELSE IF( $this->m_Type == 'object' ){
                $Reflection = new ReflectionClass($this->m_Result);
                IF($Reflection->implementsInterface('IActionResult'))
                    return $this->m_Result->getResult();
            }
            return null;
        }
    }