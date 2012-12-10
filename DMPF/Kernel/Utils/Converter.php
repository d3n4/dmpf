<?
    /**
     * Objects converter
     */
     
    Abstract Class Converter {
        
        /**
         * Convert Array to Object
         * @param Array $array
         * @return \stdClass|null result
         */
        Public Static Function ArrayToObject($array)
        {
            IF(!is_array($array))
                return $array;
            $object = new stdClass();
            IF (is_array($array) && sizeof($array) > 0) {
              ForEach ($array As $name=>$value) {
                 $name = trim($name);
                 if (!empty($name))
                    $object->{$name} = Converter::ArrayToObject($value);
              }
              return $object; 
            }
            ELSE
              return null;
        }

        /**
         * Convert Object to Array
         * @param Object $object
         * @return \Array|null result
         */
        Public Static Function ObjectToArray($object)
        {
            IF(!is_object($object))
                return $object;
            $object = Array();
            IF (is_object($object) && sizeof($object) > 0) {
                ForEach ($object As $name=>$value) {
                    $name = trim($name);
                    if (!empty($name))
                        $object[$name] = Converter::ObjectToArray($value);
                }
                return $object;
            }
            ELSE
                return null;
        }
        
        /**
         * preg_match_all to Array
         * @param array $pma preg_match_all array
         * @return array result
         */
        Public Static Function pma2Array($pma) 
        { 
            $rt = Array();
            For ($z = 0;$z < sizeof($pma);$z++)
                For ($x = 0;$x < sizeof($pma[$z]);$x++)
                    $rt[$x][$z] = $pma[$z][$x];  
            return $rt; 
        } 
    }