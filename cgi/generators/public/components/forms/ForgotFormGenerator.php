<?php
/**
 * @package limba.generators.public.components.forms
 * @author  Ludovic Reenaers
 * @since 4 nov. 2010
 * @link http://code.google.com/p/limba
 */

class ForgotFormGenerator extends FormGenerator{
	function setUp(){
		$labels = array('{ERROR-HERE}','{encoding}','{url}','{maillabel}','{mailinfo}','{forgotbutton}','{title}');
		$values = array($this->error,$_SESSION['encoding'],$_SERVER['SCRIPT_NAME'],$this->params['translator']->mail,$this->params['translator']->mailinfo,$this->params['translator']->forgotbutton,$this->params['translator']->forgotpws);
		$template = file_get_contents("html/templates/forms/forgot");
		$this->content .=str_replace($labels,$values,$template);
	}
}
?>