<?
    define('ROOT', str_replace('\\','/', dirname(__FILE__)));
    define('DMPF_PATH', ROOT.'/DMPF');
    define('KERNEL', DMPF_PATH.'/Kernel');
    define('APPLICATIONS', ROOT.'/Applications');
    require_once KERNEL.'/Utils/Loader.php';
    require_once DMPF_PATH.'/bootstrap.php';