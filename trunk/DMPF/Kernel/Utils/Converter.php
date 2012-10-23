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