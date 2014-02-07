<?php
/**
 * @package limba.util
 * @author  Ludovic Reenaers
 * @since 30 mar. 2011
 * @link http://code.google.com/p/limba
 */

class DebugHelper{
	public static function get_callstack() {
	  $dt = debug_backtrace();
	  $cs = '';
	  foreach ($dt as $t) {
	    $cs .="<br/>".$t['file'] . ' line ' . $t['line'] . ' function ' . $t['function'] . "()\n";
	  }
	
	  return $cs;
	}
	public static function handleError($errno, $errstr, $errfile, $errline){
		 if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    	}
    	//echo $errstr.' '.$errfile.'::'.$errline;
    	switch ($errno) {
    		case E_USER_ERROR:
		        FormManager::handleUserError($errstr);
		        break;

		    case E_USER_WARNING:
		        FormManager::handleUserWarning($errstr);
		        break;

		    case E_USER_NOTICE:
		        FormManager::handleUserNotice($errstr.' '.$errfile.'::'.$errline);
		        break;

		    default:
		       	FormManager::handleUnknownError($errstr.' '.$errfile.'::'.$errline);
		        break;
    	}
    	
		if($errstr == 'ERR_LACK_OF_PRIVILEGE'){	
			//echo  $errstr.' '.$errfile.'::'.$errline;
        	$_SESSION['backUrl'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        	if($_SERVER['SCRIPT_NAME']<>'/embed.php'){
        		echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL='.$_SERVER['SCRIPT_NAME'].'?/login/show/">';
        	}else{
        		echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=/index.php?/login/show/">';
        	}
		}else{
    		FormManager::redirectWrong();
		}
    return true;
	}

	public static function handleException(Exception $e)
    {
    	//echo $errstr.' '.$errfile.'::'.$errline;
    	FormManager::handleUserException($e->getMessage().' '.$e->getFile()."//".$e->getLine().":::".$e->getTraceAsString());
    	FormManager::redirectWrong(); 
    }
	
}