<?
    Class Model Implements IModel {
        
        Public $id = 0;
        
        /**
         * Get instance of Model object
         * @return Model self
         */
        Public Static Function Instance(){
            return new self();
        }
        
        Public Function Get($Key){
            return $this->{$Key};
        }
        
        Public Function Set($Key, $Value){
            $this->{$Key} = $Value;
            return $this;
        }
        
        Public Function Assign($Object){
            $self = get_class($this) == __CLASS__;
            ForEach( (Object) $Object As $Key => $Value )
                IF($self)
                    $this->{$Key} = $Value;
                ELSE
                    IF( isset($this->{$Key}) )
                        $this->{$Key} = $Value;
            return $this;
        }
    }