<?
    /**
     * Router interface
     */
    Interface IRoute {
        Public Function getMethod();
        Public Function getUri();
        Public Function getControllerName();
        Public Function getController();
        Public Function getAction();
}