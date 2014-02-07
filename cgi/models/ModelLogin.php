<?php
/**
 * @package limba.models
 * @author  Ludovic Reenaers
 * @since 20 oct. 2010
 * @link http://code.google.com/p/limba
 */

class ModelLogin extends Model{
	function remind(){
		$usrdao = $this->factory->getUserDAO();
		$usr = $usrdao->getByEmail($_POST['email']);
		if(!is_a($usr, 'User') && $usr->isActive()){
			trigger_error("ERR_UNKNOWN_EMAIL", E_USER_ERROR);
		}else{
			$to  = $_POST['email'] ;
			$subject = $this->params['translator']->hereispws;
			$message = '<html><head><title>'.$subject.'</title></head><body>';
			$message .= $this->params['translator']->youasked;
			$hash = md5($usr->getEmail().$usr->getPwsHash());
			$message .= '<br/><a href="'.(string)$this->params['config']->siteurl.$_SERVER['SCRIPT_NAME'].'?/user/reset/'.$to.'/'.$hash.'/">'.$this->params['translator']->clickhere.'</a><br/>';
			$message .= '</body></html>';
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset='.$_SESSION['encoding']. "\r\n";
			$headers .= 'Reply-To: webmaster@example.com' . "\r\n";
			$headers .= 'X-Mailer: PHP/' . phpversion(). "\r\n";
			$headers .= 'To: '.$usr->getName().', '.$usr->getSurname().' <'.$to.'>' . "\r\n";
			$headers .= "X-Priority: 1 (Higuest)\n";
			$headers .= "X-MSMail-Priority: High\n";
			$headers .= "Importance: High\n";
			$headers .= 'From: Administrateur <'.(string)$this->params['config']->info.'>' . "\r\n";
			mail($to, $subject, $message, $headers);
		}
		return "";
	}
	function show(){
		$generator = new LoginFormGenerator($this->params,$this->factory);
		$generator->addChild(new ThirdFailureCaptchaGenerator($this->params,$this->factory));
		return $generator;
	}
	function forgot(){
		FormManager::setUrls($_SERVER['SCRIPT_NAME']."?/login/mailsent/",$_SERVER['SCRIPT_NAME'].'?/login/notfound/');
		$generator = new ForgotFormGenerator($this->params,$this->factory);
		return $generator;
	}
	function mailsent(){
		return true;
	}
	function notfound(){
		return true;
	}
}
?>