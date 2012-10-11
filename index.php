<?
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    define('ROOT', str_replace('\\','/', dirname(__FILE__)));
    define('DMPF_PATH', ROOT.'/DMPF');
    define('KERNEL', DMPF_PATH.'/Kernel');
    define('APPLICATIONS', ROOT.'/Applications');
    define('APPLICATION', 'hardlook');
    require_once KERNEL.'/Utils/Loader.php';
    
    Loader::index(ROOT);
    Loader::index(DMPF_PATH);
    Loader::index(KERNEL);
    Loader::index(KERNEL.'/Exceptions');
    Loader::index(KERNEL.'/Debug');
    Loader::index(KERNEL.'/Utils');
    Loader::index(APPLICATIONS);
    Loader::register();
    
    ExceptionHandler::Initialize();
    
    Config::Load(APPLICATIONS.'/'.APPLICATION.'/config.ini');
    
    try
    {
        IF(!Bootstrap::Boot())
            throw new BootstrapException('bootstrap error');
    } catch (Exception $e) {
        ExceptionHandler::SimulateException($e);
    }