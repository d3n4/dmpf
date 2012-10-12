<?
    Class Users {
        Public Function Index($user=null){
            echo 'Hello '. $user;
            //file_get_contents('bad');
            throw new Exception('Exception test');
        }
        
        Public Function Form($user){
            echo json_encode(array($user));
        }
    }