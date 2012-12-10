<?
    // DMPF Users Controller
    Class Users extends Controller {
        
        # GET /
        Public Function userlist(){
            //echo 'Hello World';
            $ar = Array('response' => array('users' => array(array('name'=>'denfer','age'=>19),array('name'=>'tester','age'=>20))));
            return new JSONResult($ar);
        }
        
        # POST /id([0-9]+)
        Public Function Form($name, $lastname, $login, $password){
            echo json_encode(func_get_args());
        }
        
        # GET /id([0-9]+)
        Public Function Profile($id){
            $view = new View('profile.php');
            return $view->Set('id', $id)->Set('name', 'DENFER');
        }
    }