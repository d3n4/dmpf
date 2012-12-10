<?
    Class Users {
        # GET /register
        Public Function RegisterForm(){
            $view = new View('main.php');
            return $view->Set("Content", "Registration.php")->Set("Title", l("Registration"));
        }

        # POST /register
        Public Function Register(){
            return new ActionResult(json_encode($_REQUEST));
        }

        # GET /id([0-9]+)
        Public Function Profile($id){
            $view = new View('profile.php');
            return $view->Set('id', $id)->Set('name', 'DENFER');
        }
    }

?>