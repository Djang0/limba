<?php
/**
 * @package limba.generators.public.components.forms
 * @author  Ludovic Reenaers
 * @since 11 juin 2009
 * @link http://code.google.com/p/limba
 */

class LoginFormGenerator extends FormGenerator{
	function setUp(){
		if ($_SESSION["USER_BEAN"]->getName()<>"anonymous"){
			$mailvalue = $_SESSION["USER_BEAN"]->getEmail();
		}elseif (isset($_COOKIE[(string)$this->params['config']->sitename]['email'])) {
			$mailvalue=$_COOKIE[(string)$this->params['config']->sitename]['email'];
		}else{
			$mailvalue="";
		}
		if(isset($this->params["title"]) && trim($this->params["title"])<>''){
			$title= $this->params["title"];
		}else{
			$title="";
		}		
		$labels = array('{url}','{maillabel}','{pwslabel}','{logbutton}','{register}','{forgot}','{mailinfo}','{pwsinfo}','{rememberme}','{encoding}','{mailvalue}','{ERROR-HERE}','{title}');
		$values = array($_SERVER['SCRIPT_NAME'],$this->params['translator']->mail,$this->params['translator']->pws,$this->params['translator']->login,$this->params['translator']->register,$this->params['translator']->forgotpws,$this->params['translator']->mailinfo,$this->params['translator']->pwsinfo,htmlspecialchars_decode($this->params['translator']->rememberme),$_SESSION['encoding'],$mailvalue, '',$title);
		$template = file_get_contents("html/templates/forms/showLogin");
		$this->content .=str_replace($labels,$values,$template);
		$wraped = "";
		foreach ($this->children as $child){
			$wraped.=$child->dump();
		}
		$this->content = str_replace("{WRAP-HERE}",$wraped,$this->content);
	}
}

?>
