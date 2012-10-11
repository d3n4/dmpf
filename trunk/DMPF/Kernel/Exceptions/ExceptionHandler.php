<?
Abstract Class ExceptionHandler {
    Protected Static Function ShowError($ErrorTitle, $ErrorDescription, $ErrorFile, $ErrorLine, $ErrorLines, $ErrorBackTrace)
    {
        ob_clean();
        $ErrorTitle = htmlspecialchars($ErrorTitle);
        $ErrorDescription = $ErrorDescription;
        $ErrorFile = htmlspecialchars($ErrorFile);
        $ErrorLine = htmlspecialchars($ErrorLine); 
        ForEach($ErrorLines as $errLn => $ErrorCode)
            $ErrorLines[$errLn] = htmlspecialchars($ErrorCode);
        ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title><?=$ErrorTitle?></title>
        <link rel="shortcut icon" href="http://babin.at.ua/warning_16-1-.png" />
        <style>
            a
            {
                color: #730000;
            }
            html, body, pre
            {
                margin: 0;
                padding: 0;
                font-family: Monaco, 'Lucida Console';
                background: #ECECEC;
            }

            h1
            {
                margin: 0;
                background: #A31012;
                padding: 20px 45px;
                color: #fff;
                text-shadow: 1px 1px 1px rgba(0,0,0,.3);
                border-bottom: 1px solid #690000;
                font-size: 28px;
            }

            p#detail
            {
                margin: 0;
                padding: 15px 45px;
                background: #F5A0A0;
                border-top: 4px solid #D36D6D;
                color: #730000;
                text-shadow: 1px 1px 1px rgba(255,255,255,.3);
                font-size: 14px;
                border-bottom: 1px solid #BA7A7A;
            }

            p#detail input
            {
                background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#AE1113), to(#A31012));
                border: 1px solid #790000;
                padding: 3px 10px;
                text-shadow: 1px 1px 0 rgba(0, 0, 0, .5);
                color: white;
                border-radius: 3px;
                cursor: pointer;
                font-family: Monaco, 'Lucida Console';
                font-size: 12px;
                margin: 0 10px;
                display: inline-block;
                position: relative;
                top: -1px;
            }

            h2
            {
                margin: 0;
                padding: 5px 45px;
                font-size: 12px;
                background: #333;
                color: #fff;
                text-shadow: 1px 1px 1px rgba(0,0,0,.3);
                border-top: 4px solid #2a2a2a;
            }

            pre
            {
                margin: 0;
                border-bottom: 1px solid #DDD;
                text-shadow: 1px 1px 1px rgba(255,255,255,.5);
                position: relative;
                font-size: 12px;
                overflow: hidden;
            }

            pre span.line
            {
                text-align: right;
                display: inline-block;
                padding: 5px 5px;
                width: 30px;
                background: #D6D6D6;
                color: #8B8B8B;
                text-shadow: 1px 1px 1px rgba(255,255,255,.5);
                font-weight: bold;
            }

            pre span.code
            {
                padding: 5px 5px;
                position: absolute;
                right: 0;
                left: 40px;
            }

            pre:first-child span.code
            {
                border-top: 4px solid #CDCDCD;
            }
            pre:first-child span.line
            {
                border-top: 4px solid #B6B6B6;
            }
            pre.error span.line
            {
                background: #A31012;
                color: #fff;
                text-shadow: 1px 1px 1px rgba(0,0,0,.3);
            }

            pre.error
            {
                color: #A31012;
                
            }

            pre.error span.marker
            {
                background: #A31012;
                color: #fff;
                text-shadow: 1px 1px 1px rgba(0,0,0,.3);
                font-weight: bold;
            }
        </style>
    </head>

    <body>
        <h1><?=$ErrorTitle?></h1>
        <p id="detail">
        <?=$ErrorDescription?>
        </p>

        <h2>In <?=$ErrorFile?> at line <?=$ErrorLine?>.</h2>
        <div>
            <? $ln = 0; ForEach($ErrorLines as $Line=>$Code){ $ln++;
            $iserrln = false;
            IF( $Line == $ErrorLine )
            {
                $iserrln = true;
                For($i=0;$i<strlen($Code)-1;$i++)
                {
                    IF($Code[$i] == ' ' or $Code[$i] == "\t")
                        continue;
                    $marker = $Code[$i];
                    break;
                }

                $Code = explode($marker, $Code, 2);

                $Code = $Code[0].'<span class="marker">'.$marker.'</span>'.$Code[1];
            }
            ?>
            <pre<? IF($iserrln){ ?> class="error" <? } ?>><span class="line"><?=$Line?></span><span class="code"><?=$Code?></span></pre>
            <? } IF(sizeof($ErrorBackTrace)>2){ ?>
            <h2>Backtrace</h2>
            <?
            $ecline = 1;
            ForEach ($ErrorBackTrace as $entry) 
            {
                IF($entry['function'] == 'SimulateError' or $entry['function'] == 'SimulateException') continue;

                IF(isset($entry['class']))
                    $trace = $entry['class'].'::'.$entry['function'];
                ELSE IF(isset($entry['function']))
                    $trace =  $entry['function'];

                $trace .= " (";

                $fargs = '';

                IF(sizeof($entry['args'])>0)
                {
                    $fargs .= ' ';
                    ForEach((array)$entry['args'] as $argId=>$arg)
                    {
                        $fargs .= self::getArgument ($arg);
                        IF( $argId < sizeof($entry['args'])-1 )
                            $fargs .= ', ';
                    }
                    $fargs .= ' ';
                }

                $trace .= $fargs;

                $trace .= ')<small style="color: gray;"> ';
                IF(isset($entry['file']))
                    $trace .= $entry['file'];
                ELSE
                    $trace .= $ErrorFile;
                $trace .= '</small>';
                $Error = $ecline == 1;
                IF($Error)
                {
                    $marker = $trace[0];
                    $trace = substr($trace,1,strlen($trace)-1);
                    $trace = '<span class="marker">'.$marker.'</span>'.$trace;
                }
                ?>
                <pre<?IF($Error){?> class="error" <?}?>><span class="line"><?=$ecline?></span><span class="code"><?=$trace?></span></pre>
                <?
                $ecline++;
            }
            }
            ?>
        </div>
    </body>
    </html>
        <?
        exit;
    }

    Protected Static Function getArgument($arg)
    {
        IF($arg === null)
            return 'NULL';
        Switch (strtolower(gettype($arg)))
        {
            case 'string':
                return( '"'.str_replace( array("\n"), array(''), $arg ).'"' );
            case 'boolean':
                return String($arg);
            case 'object':
                return 'object('.get_class($arg).')';
            case 'array':
                $ret = 'array( ';
                $separtor = '';
                foreach ($arg as $k => $v) {
                    $ret .= $separtor.getArgument($k).' => '.getArgument($v);
                    $separtor = ', ';
                }
                $ret .= ' )';
                return $ret;
            case 'resource':
                return 'resource('.get_resource_type($arg).')';
            default:
                return var_export($arg, true);
        }
    }

    Public Static Function SimulateError($errno, $errstr, $errfile, $errline, $e = null)
    {
        IF(!Config::Read('developer')->debug) return true;
        # IF(!(error_reporting() & $errno)) return true; #

         $errorType = array (
                   E_ERROR          => 'ERROR',
                   E_WARNING        => 'WARNING',
                   E_PARSE          => 'PARSING ERROR',
                   E_NOTICE         => 'NOTICE',
                   E_CORE_ERROR     => 'CORE ERROR',
                   E_CORE_WARNING   => 'CORE WARNING',
                   E_COMPILE_ERROR  => 'COMPILE ERROR',
                   E_COMPILE_WARNING => 'COMPILE WARNING',
                   E_USER_ERROR     => 'USER ERROR',
                   E_USER_WARNING   => 'USER WARNING',
                   E_USER_NOTICE    => 'USER NOTICE',
                   E_STRICT         => 'STRICT NOTICE',
                   E_RECOVERABLE_ERROR  => 'RECOVERABLE ERROR'
                   );
         
        $err = 'CAUGHT ';
        
        IF($e !== null)
            $err .= get_class($e);
        ELSE
            $err .= 'EXCEPTION';
        
        IF (@array_key_exists($errno, $errorType))
            $err = $errorType[$errno];

        $file = file($errfile);

        $errlines = array();

        For( $ln = $errline - 5; $ln <  $errline + 5; $ln ++ )
            IF(isset($file[$ln]))
                $errlines[$ln+1] = $file[$ln];

        $backtrace = debug_backtrace();

        $Skip = Array('filemtime');

        ForEach($Skip As $Func)
            IF($backtrace[1]['function'] == $Func)
                return true;

        self::ShowError($err, $errstr, $errfile, $errline, $errlines, $backtrace); 
        return true;
    }

    Public Static Function SimulateException($Exception)
    {
        self::SimulateError($Exception->getCode(), $Exception->getMessage(), $Exception->getFile(), $Exception->getLine(), $Exception);
    }
    
    Public Static Function Initialize(){
        set_error_handler( 'ExceptionHandler::SimulateError', E_ERROR | E_WARNING | E_PARSE | 
                                    E_NOTICE | E_CORE_ERROR | E_CORE_WARNING | 
                                    E_COMPILE_ERROR | E_COMPILE_WARNING | 
                                    E_USER_ERROR | E_USER_WARNING | E_USER_NOTICE | 
                                    E_STRICT | E_RECOVERABLE_ERROR );

        set_exception_handler( 'ExceptionHandler::SimulateException' );
    }
}