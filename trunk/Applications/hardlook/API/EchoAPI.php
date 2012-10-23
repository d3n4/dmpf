<?
    Class EchoAPI extends Module {
        Public Static Function test($userId, $someArg){
            return array('message'=>'Hello '. $userId, 'args'=>$someArg);
        }
    }