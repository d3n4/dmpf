<?
    Class tests {
        # GET /test/model #
        Public Function Index(){
            $response = '';
            $Driver = Driver::Get();
            $response .= get_class($Driver->Get());
            $response .= ' Connecting... ';
            $response .= $Driver->Connect() ? 'true' : 'false';
            $response .= json_encode( $Driver->Select(array('What'=>array('id', 'login'), 'Where'=>array('Key'=>'id','Operator'=>'>','Value'=>1)), 'users') );
            return new ActionResult($response);
        }
    }