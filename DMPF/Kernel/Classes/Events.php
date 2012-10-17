<?

    Abstract Class Events {
        Protected Static $m_Events = Array();
        
        /**
         * Listen event
         * @param string $event event name
         * @param callback $callback callback
         */
        Public Static Function Add($event, $callback){
            self::$m_Events[strtoupper(trim($event))] = $callback;
        }
        
        /**
         * Call event
         * @param string $event event name
         * @param array $param_arr callback arguments
         * @return mixed event result
         */
        Public Static Function Call($event, $param_arr){
            $callback = self::$m_Events[strtoupper(trim($event))];
            IF(is_callable($callback))
                return call_user_func_array ($callback, $param_arr);
        }
    }