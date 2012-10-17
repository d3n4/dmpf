<?
    /**
     * Route
     */
    Class Route extends Properties implements IRoute {
        
        /**
         * Constants
         */
        Const ALL = 0xF0, GET = 'GET', POST = 'POST', NO_CONTROLLER = 0xF1, NO_ACTION = 0xF2;
        
        # Fields
        Protected $m_Method = Route::ALL;
        Protected $m_Uri = '/';
        Protected $m_Controller = Route::NO_CONTROLLER;
        Protected $m_Action = Route::NO_ACTION;
        
        # Properties #
        Public Function getMethod(){return $this->m_Method;}
        Public Function getUri(){return $this->m_Uri;}
        Public Function getControllerName(){return $this->m_Controller;}
        Public Function getController(){return $this->m_Controller.'.'.$this->m_Action;}
        Public Function getAction(){return $this->m_Action;}
        
        Public Function __construct($Method, $Uri, $Controller, $Action) {
            $this->m_Method = $Method;
            $this->m_Uri = $Uri;
            $this->m_Controller = $Controller;
            $this->m_Action = $Action;
        }
    }