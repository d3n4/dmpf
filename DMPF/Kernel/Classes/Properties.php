<?
    Class Properties {
        Protected $m_Writable = false;
        Public Function __get($Name) {
            $callback = Array( $this, 'get'.$Name );
            IF(is_callable($callback))
                return call_user_func ($callback);
        }
        
        Public Function __set($Name, $Value) {
            $callback = Array( $this, 'set'.$Name );
            IF(is_callable($callback))
                call_user_func ($callback, $Value);
            ELSE IF( $this->m_Writable === true )
                $this->{$Name} = $Value;
            ELSE
                throw new ReadOnlyPropertyException('Property '.$Name.' is readonly or undefined');
        }
        
        Public Function __toString() {
            return get_class($this);
        }
        
        /**
         * Assign properties from object/array
         * @param array|object $Object
         * @return IModel self
         */
        Public Function Assign($Object){
            $this->m_Writable = true;
            ForEach( (Object) $Object As $Key => $Value )
                   $this->__set($Key, $Value);
            $this->m_Writable = false;
            return $this;
        }
    }