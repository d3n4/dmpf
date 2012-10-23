<?
    /**
     * Template ViewModel Class
     */
    Abstract Class ViewModel implements ArrayAccess {
        Private $properties = Array();
        
        /**
         * Set viewmodel properties
         * @param array $properties
         * @return ViewModel self
         */
        Public Function set( $properties ){
            IF(is_array($properties))
                $this->properties = $properties;
            return $this;
        }
        
        /**
         * Get viewmodel properties 
         * @return array
         */
        Public Function get(){
            return $this->properties;
        }
        
        Public Function offsetExists ( $offset ){
            return isset($this->properties[$offset]);
        }
        
        Public Function offsetGet ( $offset ){
            IF(isset($this->properties[$offset]))
                return $this->properties[$offset];
            return null;
        }
        
        Public Function offsetSet ( $offset , $value ){
            return $this->properties[$offset] = $value;
        }
        
        Public Function offsetUnset ( $offset ){
            unset($this->properties[$offset]);
        }
        
        Public Function __set( $offset, $value ){
            return $this->properties[$offset] = $value;
        }
        
        Public Function __get( $offset ){
            IF(isset($this->properties[$offset]))
                return $this->properties[$offset];
            return null;
        }
    }