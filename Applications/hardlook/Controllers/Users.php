<?
    Class Users {
        
        # * /user/DENFER #
        Public Function Index($user=null){
            echo 'Hello '. $user[0];
            //file_get_contents('bad');
            //throw new Exception('Exception test');
        }
        
        # GET /index2 #
        Public Function asdofjnoliwke(){
            echo 'Hello World';
        }
        
        # POST /id([0-9]+) #
        Public Function Form($name, $lastname, $login, $password){
            echo json_encode(array($user));
        }
        
        # GET /id([0-9]+) #
        Public Function Profile($id){
            $view = new View('profile.php');
            $view->Set('name', 'DENFER');
            $view->Set('id', $id);
            return new ActionResult($view);
        }
    }