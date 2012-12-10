<?
    Abstract Class Localization {
        Private Static $m_Locale;
        Private Static $m_Storage = Array();
        Private Static $m_Loaded = false;
        Public Static Function Initialize($Locale){
            self::$m_Locale = $Locale;
        }

        Public Static Function Loaded(){
            return self::$m_Loaded;
        }

        Public Static Function Load(){
            self::$m_Loaded = true;
            $LocaleFile = APPLICATION_DIR.'/Locale/'.self::$m_Locale;
            IF(file_exists($LocaleFile)){
                ForEach( (Array) file($LocaleFile) as $Line )
                {
                    $KeyValuePair = explode('=', $Line, 2);
                    $Key = null;
                    $Value = null;

                    IF(isset($KeyValuePair[0]))
                        $Key = trim($KeyValuePair[0]);
                    IF(isset($KeyValuePair[1]))
                        $Value = trim($KeyValuePair[1]);

                    IF( $Key And $Value )
                        self::$m_Storage[$Key] = $Value;
                }
            }
        }

        Public Static Function GetWord($WordKey){
            IF(!self::$m_Loaded)
                self::Load();
            IF(isset(self::$m_Storage[$WordKey]))
                return self::$m_Storage[$WordKey];
            ELSE
                return $WordKey;
        }
    }

    Function l($WordKey){
        return Localization::GetWord($WordKey);
    }