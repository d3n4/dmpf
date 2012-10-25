<?
    Class tests {
        # GET /test/model #
        Public Function Index(){
            $response = '';
            $Driver = Driver::Get();
            $response .= get_class($Driver->Get());
            $response .= ' Connecting... ';
            $response .= $Driver->Connect() ? 'true' : 'false';
            ///*, 'Where'=>array('Key'=>'id','Operator'=>'=','Value'=>'1')*/
            $response .= json_encode( $Driver->Select(array( 'What' => array('id', 'login'), 'One' => false, 'Limit' => 1, 'Offset' => 1 ), 'users' ) );
            return new ActionResult($response);
            // Driver Connecting... true[{"id":"2","login":"tester"}]
        }
    }