<?
    // DMPF Users Controller
    Class Users {
        
        # GET / #
        Public Function asdofjnoliwke(){
            //echo 'Hello World';
            $ar = Array('response' => array('users' => array(array('name'=>'denfer','age'=>19),array('name'=>'tester','age'=>20))));
            return new JSONResult($ar);
        }
        
        # POST /id([0-9]+) #
        Public Function Form($name, $lastname, $login, $password){
            echo json_encode(array($user));
        }
        
        # GET /id([0-9]+) #
        Public Function Profile($id){
            $view = new View('profile.php');
            return $view->Set('id', $id)->Set('name', 'DENFER');
        }
    }