<?
    /**
     * Json action result
     */
    Class JSONResult implements IActionResult {
        Protected $m_Object;
        Public Function __construct($Object){
            $this->m_Object = $Object;
        }
        Public Function getResult() {
            return json_encode($this->m_Object);
        }
    }