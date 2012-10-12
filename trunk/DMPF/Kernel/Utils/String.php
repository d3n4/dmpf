<?
    /**
     * String extension class
     */
    Abstract Class String {
        
        /**
         * Empty char
         */
        Const EmptyChar = '';
        
        /**
         * Check is string start with delimiter
         * @param string $delimiter Delimiter
         * @param string $string String
         * @return boolean Is "$string" start with "$delimiter"
         */
        Public Static Function startWith($delimiter, $string){
            For($i = 0; $i < strlen($delimiter); $i++)
                IF($string[$i] !== $delimiter[$i]) return false;
            return true;
        }
        
        /**
         * Check is string end with delimiter
         * @param string $delimiter Delimiter
         * @param string $string String
         * @return boolean Is "$string" end with "$delimiter"
         */
        Public Static Function endWith($delimiter, $string){
            For($dIndex = strlen($delimiter)-1; $dIndex > -1; $dIndex--)
                IF($delimiter[$dIndex] !== $string[strlen($string) - (strlen($delimiter)-$dIndex)]) return false;
            return true;
        }
        
        /**
         * Append "$input" to the end of "$string"
         * @param string $input
         * @param string $string
         * @return string append result
         */
        Public Static Function Append($input, &$string){
            $string = $string.$input;
        }
        
        /**
         * Prepend "$input" to the string of "$string"
         * @param string $input
         * @param string $string
         * @return string Prepend result
         */
        Public Static Function Prepend($input, &$string){
            $string = $input.$string;
        }
        
        /**
         * Format text
         * @param string $input format string
         * @return string format result
         */
        Public Static Function Format($input){
            For($i = 1; $i < sizeof(func_get_args()); $i++)
                $input = str_replace ('{'.($i-1).'}', func_get_arg($i), $input);
            return $input;
        }
    }