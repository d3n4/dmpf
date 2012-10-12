<?
    Class Data {
        Public Function Index(){
            echo 'Hello data';
            file_get_contents('bad_filename');
        }
        
        Public Function Form($user){
            echo json_encode(array($user));
        }
    }