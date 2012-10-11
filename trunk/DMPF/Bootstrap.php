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
            echo 'Booting...';
            $bootdata = file_get_contents('.boot');
            boot($bootdata);
            return false;
        }
    }