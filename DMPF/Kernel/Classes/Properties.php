<?
    Class Properties { 
        Public Function __get($Name) {
            $callback = Array( $this, 'get'.$Name );
            IF(is_callable($callback))
                return call_user_func ($callback);
        }
        
        Public Function __set($Name, $Value) {
            $callback = Array( $this, 'set'.$Name );
            IF(is_callable($callback))
                call_user_func ($callback, $Value);
            ELSE
                throw new ReadOnlyPropertyException('Property '.$Name.' is readonly or undefined');
        }
        
        Public Function __toString() {
            return get_class($this);
        }
    }