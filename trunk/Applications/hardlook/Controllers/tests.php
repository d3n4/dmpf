<?
    Class tests {
        # GET /test/model #
        Public Function Index(){
            $response = '';
            $Driver = Driver::Get();
            $response .= 'Connecting... ';
            $response .= $Driver->Connect() ? 'true' : 'false';
            $users = Collection::Get('users', 'User');
            $response .= $users->Count();
            $user = new User;
            $user->login = 'sock';
            $user->password = 'test';
            $users->Insert($user);
            
            $userslist = $users->Find(Query::None());
            /* @var User[] $userlist */
            $userslist[0] -> id = 2;
            
            $response .= json_encode( $userslist );
            
            return new ActionResult($response);
            
            /*$response .= $Driver->Count('users');
            $Driver->Insert('users',array('id'=>null,'login'=>'tester'.microtime(1), 'password'=>'pw'.rand(0,10000)));
            $response .= $Driver->Delete('users', Query::Equal('id', 5));
            $response .= json_encode( $Driver->Select( 'users', Query::None() ) );*/
            
            // Connecting... true[{"id":"1","login":"denfer","password":"123123"}]
        }
    }