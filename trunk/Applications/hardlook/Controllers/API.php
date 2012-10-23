<?
    Class API_Controller {
        # * /api/([a-zA-Z0-9_]+).([a-zA-Z0-9_]+) #
        Public Function invoke($module, $action){
            return new JSONResult( API::Call($module, $action, $_REQUEST) );
        }
    }