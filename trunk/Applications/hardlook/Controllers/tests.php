<?
    Class tests {
        # GET /test
        Public Function Index(){
            $response = '';
            $Driver = Driver::Get();

            $response .= 'Connecting... ';
            $response .= $Driver->Connect() ? 'true' : 'false';

            //$response .= $users->Count();
            /*$user = new User;
            $user->login = 'DENFER';
            $user->password = '123123';
            $user->save();
            $user->password = md5($user->password);
            $user->save();*/

            $users = Collection::Get('users', 'User');
            

            //$user->password = md5($user->password);
            //$user->save();

            //$userslist = Collection::Get('users', 'User')->Find(Query::None());
            /* @var User[] $userlist */
            //$userslist[0] -> id = 2;
            
            //$response .= json_encode( $userslist );
            
            return new ActionResult($response);
            
            /*$response .= $Driver->Count('users');
            $Driver->Insert('users',array('id'=>null,'login'=>'tester'.microtime(1), 'password'=>'pw'.rand(0,10000)));
            $response .= $Driver->Delete('users', Query::Equal('id', 5));
            $response .= json_encode( $Driver->Select( 'users', Query::None() ) );*/
            
            // Connecting... true[{"id":"1","login":"denfer","password":"123123"}]
        }
    }