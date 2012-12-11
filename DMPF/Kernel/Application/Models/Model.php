<?
    Class Model extends Properties implements IModel {

        Protected $_id = null;

        Protected $CollectionName;

        /**
         * @var ICollection Collection
         */
        Protected $Collection;

        Public Function Model(){
            $this->Collection = Collection::Get($this->CollectionName);
        }

        Public Function getid(){
            return $this->_id;
        }

        Public Function setid($id){
            $this->_id = $id;
        }

        /**
         * Get instance of Model object
         * @param string $Collection
         * @return Model self
         */
        Public Static Function Instance($Collection){
            return new self($Collection);
        }
        
        Public Function Get($Key){
            return $this->{$Key};
        }
        
        Public Function Set($Key, $Value){
            $this->{$Key} = $Value;
            return $this;
        }

        Public Function save(){
            IF($this->_id === null)
            {
                $this->Collection->Insert($this);
                $this->_id = mysql_insert_id();
            }
            $this->Collection->Update($this, Query::Equal('id', $this->_id));
        }
    }