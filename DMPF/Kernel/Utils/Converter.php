<?
    /**
     * Objects converter
     */
     
    Abstract Class Converter {
        
        /**
         * Convert Array to Object
         * @param Array $array
         * @return \stdClass|boolean Convertion result
         */
        Public Static Function ArrayToObject($array)
        {
            IF(!is_array($array))
                return $array;
            $object = new stdClass();
            IF (is_array($array) && count($array) > 0) {
              ForEach ($array As $name=>$value) {
                 $name = strtolower(trim($name));
                 if (!empty($name)) {
                    $object->$name = Converter::ArrayToObject($value);
                 }
              }
              return $object; 
            }
            ELSE
              return False;
        }
    }