<?
    Class Model extends Properties implements IModel {
        
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
    }