<?
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    define('APPLICATION', 'hardlook');
    
    define('ROOT', str_replace('\\','/', dirname(__FILE__)));
    define('DMPF_PATH', ROOT.'/DMPF');
    define('KERNEL', DMPF_PATH.'/Kernel');
    define('APPLICATIONS', ROOT.'/Applications');
    define('APPLICATION_DIR', APPLICATIONS.'/'.APPLICATION);
    define('ROUTES_FILE', APPLICATIONS.'/'.APPLICATION.'/Routes');
    require_once KERNEL.'/Classes/Loader.php';
    
    Loader::index(ROOT);
    Loader::index(DMPF_PATH);
    Loader::index(KERNEL);
    Loader::index(KERNEL.'/Classes');
    Loader::index(KERNEL.'/Exceptions');
    Loader::index(KERNEL.'/Debug');
    Loader::index(KERNEL.'/Utils');
    Loader::index(KERNEL.'/Database');
    Loader::index(KERNEL.'/Database/Drivers');
    Loader::index(KERNEL.'/Application');
    Loader::index(KERNEL.'/Application/Controllers');
    Loader::index(KERNEL.'/Application/Models');
    Loader::index(KERNEL.'/Application/Views');
    Loader::index(KERNEL.'/Application/Router');
    Loader::index(APPLICATIONS);
    Loader::index(APPLICATION_DIR);
    Loader::index(APPLICATION_DIR.'/Controllers');
    Loader::index(APPLICATION_DIR.'/Models');
    Loader::index(APPLICATION_DIR.'/Views');
    Loader::register();
    
    Storage::init();
    
    Config::Load( APPLICATION_DIR.'/config.ini' );
    
    ExceptionHandler::Initialize();
    
    IF(!isset($_GET['uri']))
        ExceptionHandler::SimulateError ('0', 'Security error', 'Kernel', 0);
    
    $Stopwatch = Stopwatch::Create('Framework');
    
    try
    {
        IF(!Bootstrap::Boot())
            throw new BootstrapException('Failed to boot up framework');
    } catch (Exception $e) {
        ExceptionHandler::SimulateException($e);
    }
    
    
    $devConf = Config::Read('developer');
    IF($devConf['debug'])
        $Stopwatch->Log();