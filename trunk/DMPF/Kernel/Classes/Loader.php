<?

    /**
     * Class to automatically load classes by class name
     */

    Abstract Class Loader
    {
        
        /**
         * Count of loadded scripts
         * @var int Count of loadded scripts
         */
        Protected Static $Count = 0;
        
        /**
         * Indexes memory
         * @var array List of indexes
         */
        Protected Static $Index = Array();
        
        /**
         * Aliasses memory
         * @var array List of aliasses
         */
        Protected Static $Alias = Array();
        
        /**
         * Get count of loadded scripts
         * @return int count
         */
        Public Static Function count(){
            return self::$Count;
        }
        
        /**
         * Create alias to include file by class name
         * @param string $Class Class name
         * @param string $File File name
         */
        Public Static Function alias($Class, $File){
            self::$Alias[$Class] = $File;
        }
        
        /**
         * Index files from directory
         * @param string $path Folder path
         */
        Public Static Function index($path){
            self::$Index[trim($path)] = true;
        }

        /**
         * Remove indexing from directory
         * @param string $path Folder path
         */        
        Public Static Function deindex($path){
            unset(self::$Index[trim($path)]);
        }

        /**
         * Check folder for indexing
         * @param string $path Folder path
         * @return bool
         */
        Public Static Function indexed($path){
            return isset(self::$Index[trim($path)]);
        }

        /**
         * Try to load class manual
         * @param string $Class class pattern name
         * @return bool Result
         */        
        Public Static Function load($Pattern){
            self::$Count++;
            IF(isset(self::$Alias[$Pattern])){
                IF(file_exists(self::$Alias[$Pattern])){
                    require_once self::$Alias[$Pattern];
                    return;
                }
                $Pattern = self::$Alias[$Pattern];
            }
            ForEach( self::$Index As $Index => $Enabled  )
                ForEach( glob($Index.'/'.$Pattern.'.php') As $File )
                    IF( file_exists($File) && $Enabled )
                        require_once $File;
        }

        Public Static Function loadAll($Path){
            ForEach( (Array) glob($Path . '/*.php') As $File )
                require_once $File;
        }
        
        /**
         * Initialize loader
         */
        Public Static Function register(){
            spl_autoload_register('Loader::load');
        }

        /**
         * Deinitialize loader
         */
        Public Static Function unRegister(){
            spl_autoload_unregister('Loader::load');
        }
    }