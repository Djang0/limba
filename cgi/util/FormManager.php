<?php
/**
 * @package limba.util
 * @author  Ludovic Reenaers
 * @since 30 mar. 2011
 * @link http://code.google.com/p/limba
 */

class FormManager{

	public static function setFallBackUrl($url){
		if(array_key_exists('wrapperurl',$_SESSION) ){
			$_SESSION['fallBackUrl']=$_SESSION['wrapperurl'];
			unset($_SESSION['wrapperurl']);
		}else{
			$_SESSION['fallBackUrl']=$url;
		}
	}
	public static function redirectWrong(){
//		if(isset($_SESSION['fallBackUrl'])){
//			echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL='.$_SESSION['fallBackUrl'].'">';
//		}else{
//			echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL='.$_SERVER['SCRIPT_NAME'].'?/homepage/show/">';
//		}
	}
	public static function redirectGood(){
//		if(isset($_SESSION['okUrl'])){
//			$tmp = $_SESSION['okUrl'];
//		}else{
//			$tmp = $_SERVER['SCRIPT_NAME'].'?/homepage/show/';
//		}
//		self::flush();
//		echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL='.$tmp.'">';
	}
	public static function setUrls($OkUrl,$FbackUrl){
		if(array_key_exists('wrapperurl',$_SESSION) ){
			$_SESSION['okUrl'] = $_SESSION['wrapperurl'];
			unset($_SESSION['wrapperurl']);
		}else{
			$_SESSION['okUrl'] = $OkUrl;
		}
		$_SESSION['fallBackUrl'] = $FbackUrl;
	}
	public static function addValidationRule($propId, $validationMethodTab){
		if(!isset($_SESSION['validators']) || is_null($_SESSION['validators'])){
			$_SESSION['validators'] = array();
		}
		$_SESSION['validators'][$propId]=$validationMethodTab;
	}
	public static function validateProperty($propId,$value){
		$bool = true;
		if(isset($_SESSION['validators']) && !is_null($_SESSION['validators'])){
			foreach($_SESSION['validators'] as $key=>$val){
				if((int)$key == (int)$propId){
					$methTab = $val;
					foreach ($methTab as $meth){
						Validator::$meth($value); 
					}
				}
			}
		}
		return $bool;
	}
	public static function flush(){
		$_SESSION['validators']= array();
		unset($_SESSION['fallbackurl']);
		unset($_SESSION['wrapperurl']);
		unset($_SESSION['okUrl']);
	}

	public static function handleUserError($errStr){
			$_SESSION['errBool'] = true;
			array_push($_SESSION['errors']['err'],$errStr);
	}
	public static function handleUserWarning($errStr){
			$_SESSION['errBool'] = true;
			array_push($_SESSION['errors']['warn'],$errStr);
	}
	public static function handleUserNotice($errStr){
			$_SESSION['errBool'] = true;
			array_push($_SESSION['errors']['note'],$errStr);
	}
	public static function handleUnknownError($errStr){
			$_SESSION['errBool'] = true;
			array_push($_SESSION['errors']['uknw'],$errStr);
	}
	public static function handleUserException($errStr){
			$_SESSION['errBool'] = true;
			array_push($_SESSION['errors']['except'],$errStr);
	}
}
?>