<?
    /**
     * Template view interface
     */
    Interface IView {
        Public Function Compile();
        Public Function Load($template);
    }