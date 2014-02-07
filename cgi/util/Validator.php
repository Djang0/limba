<?php
/**
 * @package limba.util
 * @author  Ludovic Reenaers
 * @since 20 mars 2009
 * @link http://code.google.com/p/limba
 */

class Validator{
	public static function validateWordTab($tab){
		if(is_array($tab)){
			foreach ($tab as $value){
				if(!is_a($value, 'Word')){
					trigger_error("ERR_NOT_A_LISTVALUE", E_USER_NOTICE);
				}
			}
		}else{
			trigger_error("ERR_NOT_AN_ARRAY", E_USER_ERROR);
		}
	}
	public static function validateCaptcha ($captcha){
		$securimg = new Securimage();
		$captchabool = $securimg->check($captcha);
		if(!$captchabool){
			trigger_error("ERR_INVALID_CAPTCHA", E_USER_ERROR);
		}
	}
	public static function validateId($id){
		try{
			$id = (int) $id;
		}catch (Exception $e){
			trigger_error("ERR_INVALID_ID", E_USER_ERROR);
		}
		if (!is_int($id)||$id < 0){
			DebugHelper::get_callstack();
			trigger_error("ERR_INVALID_ID", E_USER_ERROR);
		}
	}
	public static function validateEmail($email){
		if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)&& (strlen($email) > 0 && strlen($email) < 256)) {
			trigger_error("ERR_INVALID_EMAIL", E_USER_ERROR);
		}
	}
	public static function validateIp($ip){
		if(!preg_match("^([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}^", $ip)) {
			//echo $ip;
			trigger_error("ERR_INVALID_IP", E_USER_ERROR);
		}
	}
	
	public static function validateInterval($dt1,$dt2){
		try{
			$dt1->format("Ymd");
			$dt2->format("Ymd");
			if($dt1>$dt2){
				trigger_error("ERR_INVALID_INTERVAL", E_USER_ERROR);
			}
		}catch(Exception $e){
			trigger_error("ERR_INVALID_INTERVAL", E_USER_ERROR);
		}
	}
	public static function validateDate($day,$month,$year){
		if(!checkdate($month,$day,$year)){
			trigger_error("ERR_BAD_DATE_FORMAT", E_USER_ERROR);
		}
	}
	public static function validatePassword($pws){
		if(strlen($pws)<6){
			trigger_error("ERR_INVALID_PASSWORD", E_USER_ERROR);
		}
	}
	public static function validateHash($hash){
		// 32 char alphanumeric only
		if(!strlen($hash)==32 || !ctype_alnum($hash)){
			trigger_error("ERR_BAD_HASH_FORMAT", E_USER_ERROR);
		}
	}
}
?>
