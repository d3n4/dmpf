<?

    /**
     * MySQL driver
     */
    Class MySQL Implements IDriver {
        
        Protected $m_Connected = false, $Link, $Host, $Username, $Password, $Database;
        
        Protected Static $m_CountInstance = null;
        
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
        
        Protected Function getQuery( $InputFormat, IQuery $Query, $Table ){
            IF($Query->getOne())
                $Query->setLimit (1);
            
            $Fields = $Query->getFields();
            
            IF(!$Fields)
                $Fields = '*';
            
            IF(is_array($Fields)) $Fields = implode('`, `', $Fields);
            IF($Fields != '*' && strpos('(', $Fields) < 0) $Fields = '`'.$Fields.'`';
            
            $Format = str_replace( Array('{table}', '{fields}'), Array('`'.$this->Escape($Table).'`', $Fields), $InputFormat );

            IF($Query->getObject()){
                $Object = $Query->getObject();
                $Keys = '';
                $Values = '';
                ForEach( (Object) $Object As $Key => $Value ){
                    IF(is_numeric($Key)) continue;
                    IF( strlen($Keys) > 0 )
                        $Keys .= ', ';
                    $Keys .= '`'.$Key.'`';
                    
                    IF( strlen($Values) > 0 )
                        $Values .= ', ';
                    
                    Switch(gettype($Value)){
                        case 'string':
                            $Values .= '\''.$Value.'\'';
                            break;
                        
                        case 'boolean':
                            $Values .= $Value ? 'true' : 'false';
                            break;
                        
                        case 'double':
                        case 'integer':
                            $Values .= $Value;
                            break;
                        
                        case 'NULL':
                            $Values .= 'NULL';
                            break;
                        
                        case 'object':
                        case 'array':
                            $Values .= json_encode($Value);
                            break;
                    }
                }
        
                
                $Format .= ' ( '.$Keys.' ) VALUES ( '.$Values.' )';
            }
            
            $Conditions = $Query->getConditions();
            
            IF(!is_array($Conditions) && ( is_subclass_of($Conditions, 'Condition') || get_class($Conditions) == 'Condition' ))
                $Conditions = Array($Conditions);
            
            IF(sizeof($Conditions) > 0){
                $Conditions_String = '';
                /* @var $Condition ICondition */
                ForEach ( (Array) $Conditions As $i => $Condition ){
                    IF($i > 0)
                        $Conditions_String .= ' '.$Condition->getType().' ';
                    $Conditions_String .= String::Format('`{0}` {1} \'{2}\'', $Condition->getKey(), $Condition->getOperator(), $this->Escape($Condition->getValue()));
                }
                $Format .= ' WHERE '.$Conditions_String;
            }
            
            IF($Query->getLimit() != null)
                $Format .= ' LIMIT '. $Query->getLimit();
            
            IF($Query->getOffset() != null)
                $Format .= ' OFFSET '. $Query->getOffset();
            
            return $Format;
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
        
        Public Function Insert( $Table, $Object ){
            return mysql_query( $this->getQuery('INSERT INTO {table}', Query::Object($Object), $Table) );
        }
        
        Public Function Find( $Table, IQuery $Query, $Type = 'Model' ){
            $mysql_query = mysql_query( $this->getQuery('SELECT {fields} FROM {table}', $Query, $Table) );
            IF(!$mysql_query)
                return null;
            $Result = Array();
            While($Item = mysql_fetch_array($mysql_query, MYSQL_ASSOC)){
                IF(class_exists($Type, true))
                {
                    $Model = new $Type();
                    $Item = $Model->Assign($Item);
                }
                ELSE
                    $Item = Model::Instance()->Assign($Item);
                IF($Query->getOne())
                    return $Item;
                ELSE
                    $Result[] = $Item;
            }
            mysql_free_result($mysql_query);
            return $Result;
        }
        
        Public Function Select( $Table, IQuery $Query, $Type = 'Model' ){
            return $this->Find($Table, $Query, $Type);
        }
        
        Public Function Delete( $Table, IQuery $Query ){
            return mysql_query( $this->getQuery('DELETE FROM {table}', $Query, $Table) );
        }
        
        Public Function Update( $Table, $Object, IQuery $Query ){
            
        }
        
        Public Function Truncate( $Table ){
            return mysql_query('TRUNCATE TABLE `'.$this->Escape($Table).'`');
        }
        
        Public Function Count( $Table ){
            IF(!self::$m_CountInstance)
                self::$m_CountInstance = Query::Instance()->setFields('COUNT(1)')->setOne(true);
            $Count = $this->Select($Table, self::$m_CountInstance);
            return $Count->{'COUNT(1)'};
        }
    }