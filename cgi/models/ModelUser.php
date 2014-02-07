<?php
/**
 * @package limba.models
 * @author  Ludovic Reenaers
 * @since 20 oct. 2010
 * @link http://code.google.com/p/limba
 */

class ModelUser extends Model{
	function password(){
		try{
			$url = $_SERVER['SCRIPT_NAME'].'?/homepage/show/';
			if(isset($_POST['email']) && isset($_POST['candidate']) && isset($_POST['password']) && isset($_POST['password2'])){
				if($_POST['password'] == $_POST['password2']){
					Validator::validatePassword($_POST['password']);
					if($_POST['candidate'] == md5($_SESSION['tmp_user']->getEmail().$_SESSION['tmp_user']->getPwsHash()) && $_SESSION['tmp_user']->getEmail() == $_POST['email']){
						$_SESSION['tmp_user']->setPwsHash(md5($_POST['password']),md5($_POST['password2']));
						$usrDAO = $this->factory->getUserDAO();
						$bool = $usrDAO->update($_SESSION['tmp_user']);
						if(!$bool){
							trigger_error("ERR_FAILED_UPDATE", E_USER_ERROR);
							
						}else{
							//stop form session
							unset($_SESSION['tmp_user']);
						}
					}
				}else{
					trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
					
				}
			}
		}catch (Exception $e){
			FormManager::handleUserException($e->getMessage().' '.$e->getLine());
			$url = $_SERVER['SCRIPT_NAME']."?/user/reset/".$_POST['email']."/".$_POST['candidate']."/";
		}
		return $url;
	}
	function reset(){
		$candidate = $this->params["candidate"];
		$mail = $this->params["mail"];
		$usrDAO = $this->factory->getUserDAO();
		$usr = $usrDAO->getByEmail($mail);
		$generator = null;
		if(is_a($usr, 'User') && $usr->isActive()){
			if($candidate == md5($usr->getEmail().$usr->getPwsHash())){
				$_SESSION['tmp_user'] = $usr;
				$generator = new ResetFormGenerator($this->params,$this->factory);
			}
		}
		return  $generator;
	}
	function insert(){
			$usrDao = $this->factory->getUserDAO();
			$usrBEAN = new User(0);
			$usrBEAN->setName($_POST['nom']);
			$usrBEAN->setSurname($_POST['prenom']);
			$usrBEAN->setEmail($_POST['email']);
			$usrBEAN->setStreet($_POST['rue']);
			$usrBEAN->setNumber($_POST['numero']);
			$usrBEAN->setZip($_POST['zip']);
			$usrBEAN->setCity($_POST['city']);
			$usrBEAN->setCountry($_POST['country']);
			$lngDAO = $this->factory->getLangueDAO();
			$usrBEAN->setLangue($lngDAO->getById($_POST['lng']));
			list($day,$month,$year)=preg_split('/[-\.\/ ]/',$_POST['ddn']);
			$usrBEAN->setDdn($day,$month,$year);
			Validator::validatePassword($_POST["pws"]);
			Validator::validatePassword($_POST["pws2"]);
			$usrBEAN->setPwsHash(md5($_POST["pws"]),md5($_POST["pws2"]));
			
			$securimg = new Securimage();
			$captchabool = $securimg->check($_POST['captcha_code']);
			if(!$captchabool){
				trigger_error("ERR_INVALID_CAPTCHA",E_USER_ERROR);
			}
			if($_SESSION['USER_BEAN']->getName()=='anonymous'){
			
				$profDAO = $this->factory->getProfileDAO();
				$prof = $profDAO->getByLabel('web');
				$usrBEAN->setProfile($prof);
			}
			
			$usrBEAN = $usrDao->add($usrBEAN);
			
			if(!is_a($usrBEAN, 'User')){
				trigger_error("ERR_FAILED_INSERT",E_USER_ERROR);
			}else{
				$_SESSION['USER_BEAN'] = $usrBEAN;

			}
		
		return "done!";
	}
	function update(){
		//try{
		$usrDao = $this->factory->getUserDAO();
		$_SESSION['USER_BEAN']->setName($_POST['nom']);
		$_SESSION['USER_BEAN']->setSurname($_POST['prenom']);
		$_SESSION['USER_BEAN']->setEmail($_POST['email']);
		$_SESSION['USER_BEAN']->setStreet($_POST['rue']);
		$_SESSION['USER_BEAN']->setNumber($_POST['numero']);
		$_SESSION['USER_BEAN']->setZip($_POST['zip']);
		$_SESSION['USER_BEAN']->setCity($_POST['city']);
		$_SESSION['USER_BEAN']->setCountry($_POST['country']);
		$lngDAO = $this->factory->getLangueDAO();
		
		$_SESSION['USER_BEAN']->setLangue($lngDAO->getById($_POST['lng']));
		list($day,$month,$year)=preg_split('/[-\.\/ ]/',$_POST['ddn']);
		$_SESSION['USER_BEAN']->setDdn($day,$month,$year);
		Validator::validatePassword($_POST["pws"]);
		Validator::validatePassword($_POST["pws2"]);
		$_SESSION['USER_BEAN']->setPwsHash(md5($_POST["pws"]),md5($_POST["pws2"]));
		
		$securimg = new Securimage();
		$captchabool = $securimg->check($_POST['captcha_code']);
		if(!$captchabool){
			trigger_error("ERR_INVALID_CAPTCHA",E_USER_ERROR);
		}
		$bool = $usrDao->update($_SESSION['USER_BEAN']);
		if(!$bool){
			trigger_error("ERR_FAILED_UPDATE",E_USER_ERROR);
		}
		//}catch (Exception $e){
//			while($key = key($_POST)){
//				//FormManager::addFormValue($key,$_POST[$key]);
//				next($_POST);
//			}
			//FormManager::handleUserException($e->getMessage().' '.$e->getLine());
		//}
		return "done!";
	}
	function add(){
		FormManager::setUrls($_SERVER['SCRIPT_NAME']."?/homepage/show/","http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		$generator = new UserFormGenerator($this->params,$this->factory);
		$generator->addChild(new CaptchaGenerator($this->params,$this->factory));
		return $generator;
	}
	function edit(){
		FormManager::setUrls($_SERVER['SCRIPT_NAME']."?/homepage/show/","http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		$generator = new UserFormGenerator($this->params,$this->factory);
		$generator->addChild(new CaptchaGenerator($this->params,$this->factory));
		return $generator;
	}
	function authenticate(){
		try{
			$bool = false;
			$dao = $this->factory->getUserDAO();
			$user = $dao->getByEmail($_POST['email']);
			if(isset($_POST['keep'])){
				setcookie((string)$this->params['config']->sitename.'[email]', $_POST['email']);
			}
			if(!isset($_SESSION["failedlogin"])){
				$_SESSION["failedlogin"] = 0;
			}
			if (isset($_SESSION["failedlogin"]) && $_SESSION["failedlogin"]>2){	
				$securimg = new Securimage();
				$captchabool = $securimg->check($_POST['captcha_code']);
			}
			if(is_a($user, 'User') && $user->getPwsHash() == md5($_POST['password']) && $user->getName()<>'anonymous' &&($_SESSION["failedlogin"]<=2 or ($_SESSION["failedlogin"] >2 and $captchabool))&& $user->isActive()){
				//stop form session
				unset($_SESSION["failedlogin"]);
				$_SESSION["USER_BEAN"] = $user;
				$_SESSION['langue'] = $user->getLangue()->getIso();
				$bool=true;
					
			}else{
				if ($_SESSION["failedlogin"]>2 and !$captchabool){
					throw new FieldFormatException("ERR_INVALID_CAPTCHA");
				}
				if (isset($_SESSION["failedlogin"])){
					$_SESSION["failedlogin"] = $_SESSION["failedlogin"]+1;
				}else{
					$_SESSION["failedlogin"]=1;
				}
				trigger_error("ERR_BAD_AUTHENTICATION",E_USER_ERROR);
			}
		}catch (Exception $e){
			$bool=false;
		}
		return $bool;
	}
	function logout(){
		$bool = false;
		$dao = $this->factory->getUserDAO();
		$user = $dao->getAnonymousUser();
		if(is_a($user, 'User')){
			$_SESSION['USER_BEAN'] = $user;
			$bool=true;
		}
		$_SESSION['langue']= $this->getDefaultLanguageIso();
		return $bool;
	}
}
?>