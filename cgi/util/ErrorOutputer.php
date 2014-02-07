<?php
/**
 * @package limba.util
 * @author  Ludovic Reenaers
 * @since 06 avr. 2011
 * @link http://code.google.com/p/limba
 */
class ErrorOutputer{
	static public function getOutput(){
		$_SESSION['outputed'] = true;
		$_SESSION['errBool'] = false;
		return $_SESSION['errors'];
	} 
	static public function initialize(){
		set_exception_handler(array("DebugHelper", "handleException"));
		set_error_handler(array("DebugHelper", "handleError"));
		if(!array_key_exists('outputed',$_SESSION) || $_SESSION['outputed']){
			$_SESSION['outputed'] = false;
			$_SESSION['errors'] = array();
			$_SESSION['errors']['err']=array();
			$_SESSION['errors']['warn']=array();
			$_SESSION['errors']['note']=array();
			$_SESSION['errors']['uknw']=array();
			$_SESSION['errors']['except']=array();
			$_SESSION['errBool'] = false;
		}
	}
}
