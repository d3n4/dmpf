<?
    /**
     * Framework bootstrap
     */

    Abstract Class Bootstrap
    {
        /**
         * Boot Framework
         * @return bool Framework boot result
         */
        
        Public Static Function Boot(){
            echo 'boot';
            echo 'asd';
            #file_get_contents('bad');
            #throw new Exception('test');
            return false;
        }
    }