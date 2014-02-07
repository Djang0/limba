<?php
/**
 * @package limba.generators.public.components.forms
 * @author  Ludovic Reenaers
 * @since 4 nov. 2010
 * @link http://code.google.com/p/limba
 */

class ResetFormGenerator extends FormGenerator{
	function setUp(){
		$labels = array('{ERROR-HERE}','{encoding}','{url}','{pwslabel}','{pwsinfo}','{pws2label}','{pws2info}','{resetbutton}','{candidate}','{email}');
		$values = array($this->error,$_SESSION['encoding'],$_SERVER['SCRIPT_NAME'],$this->params['translator']->labelPws,$this->params['translator']->pwsinfo,$this->params['translator']->labelPws2,$this->params['translator']->pws2info,$this->params['translator']->resetbutton,$this->params["candidate"],$this->params["mail"]);
		$template = file_get_contents("html/templates/forms/reset");
		$this->content .=str_replace($labels,$values,$template);
	}
}
?>