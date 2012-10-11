<?
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    define('APPLICATION', 'hardlook');
    
    define('ROOT', str_replace('\\','/', dirname(__FILE__)));
    define('DMPF_PATH', ROOT.'/DMPF');
    define('KERNEL', DMPF_PATH.'/Kernel');
    define('APPLICATIONS', ROOT.'/Applications');
    require_once KERNEL.'/Utils/Loader.php';
    
    Loader::index(ROOT);
    Loader::index(DMPF_PATH);
    Loader::index(KERNEL);
    Loader::index(KERNEL.'/Exceptions');
    Loader::index(KERNEL.'/Debug');
    Loader::index(KERNEL.'/Utils');
    Loader::index(KERNEL.'/Database');
    Loader::index(KERNEL.'/Database/Drivers');
    Loader::index(APPLICATIONS);
    Loader::register();
    
    Config::Load( APPLICATIONS.'/'.APPLICATION.'/config.ini' );
    
    ExceptionHandler::Initialize();
    
    $Stopwatch = Stopwatch::Create('Framework');
    
    Storage::set( 'DATABASE', new Driver() );
    
    try
    {
        IF(!Bootstrap::Boot())
            throw new BootstrapException('Failed to boot up framework');
    } catch (Exception $e) {
        ExceptionHandler::SimulateException($e);
    }
    
    IF(Config::Read('developer')->debug)
        $Stopwatch->Log();