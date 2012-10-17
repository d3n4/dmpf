<?
    Class Users {
        
        # * /azd #
        Public Function Index($user=null){
            echo 'Hello '. $user;
            //file_get_contents('bad');
            //throw new Exception('Exception test');
        }
        
        # POST /id([0-9]+) #
        Public Function Form($name, $lastname, $login, $password){
            echo json_encode(array($user));
        }
        
        # GET /id([0-9]+) #
        Public Function Profile($id){
            echo "userid: {$id}";
        }
    }