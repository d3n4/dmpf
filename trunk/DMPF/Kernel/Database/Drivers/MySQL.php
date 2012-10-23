<?

    /**
     * MySQL driver
     */
    Class MySQL Implements IDriver {
        
        Protected $m_Connected = false, $Link, $Host, $Username, $Password, $Database;
        
        Protected Function Format(){
            $args = func_get_args();
            $i = 1;
            $count = sizeof($args);
            For($i; $i<$count; $i++)
                $args[$i] = $this->Escape ($args[$i], $this->Link);
            return call_user_func_array(Array('String', 'Format'), $args);
        }
        
        Protected Function Escape($string){
            return mysql_real_escape_string($string, $this->Link);
        }
        
        Public Function SetConnectData($Host, $Username, $Password, $Database) {
            $this->Host = $Host;
            $this->Username = $Username;
            $this->Password = $Password;
            $this->Database = $Database;
        }
        
        Public Function Connect() {
            $this->Link = @mysql_connect($this->Host, $this->Username, $this->Password);
            IF($this->Link){
                @mysql_select_db($this->Database);
                $this->m_Connected = true;
                return true;
            }
            return false;
        }
        
        Public Function Disconnect() {
            $this->m_Connected = false;
            return @mysql_close($this->Link);
        }
        
        Public Function Connected() {
            return $this->m_Connected;
        }
        
        Public Function Insert( $Object, $Table ){
            
        }
        
        Public Function Select( $Query, $Table ){
            $What = isset($Query['What']) ? $Query['What'] : '*';
            $Where = isset($Query['Where']) ? $Query['Where'] : null;
            
            IF(is_array($What)) $What = implode('`,`', $What);
            IF($What != '*') $What = '`'.$What.'`';
            
            $Format = $this->Format('SELECT {0} FROM {1}', $What, $Table);
            
            IF($Where){
                $WhereKey = isset($Query['Where']['Key']) ? $Query['Where']['Key'] : null;
                $WhereOperator = isset($Query['Where']['Operator']) ? $Query['Where']['Operator'] : '=';
                $WhereValue = isset($Query['Where']['Value']) ? $Query['Where']['Value'] : null;
                IF($WhereKey !== null)
                    String::Append ( String::Format(' WHERE `{0}` {1} \'{2}\'', $this->Escape($WhereKey), $WhereOperator, $this->Escape($WhereValue)), $Format );
            }
            //echo $Format; exit;
            return mysql_fetch_array(mysql_query($Format), MYSQL_ASSOC);
        }
        
        Public Function Delete( $Query, $Table ){
            
        }
        
        Public Function Update( $Object, $Query, $Table ){
            
        }
        
        Public Function Truncate( $Table ){
            
        }
    }