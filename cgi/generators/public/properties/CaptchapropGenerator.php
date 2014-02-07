<?php
/**
 * @package limba.generators.public.properties
 * @author  Ludovic Reenaers
 * @since 17 mar. 2011
 * @link http://code.google.com/p/limba
 */

class CaptchapropGenerator extends PropertyGenerator{
	protected function getShow(){
		$labels = array('{reloadimg}','{codeinfo}','{code}','{labelprop}','{inputName}');
		$values = array($this->params['translator']->reloadimg,$this->params['translator']->codeinfo,$this->params['translator']->code,$this->Property->getInfo($_SESSION['langue']),'{str}_'.$this->Property->getId().'_'.$_SESSION['langue']);
		$template = file_get_contents($_SERVER['DOCUMENT_ROOT']."/html/templates/properties/captchaProp");
		$content =str_replace($labels,$values,$template);
		return $content;
	}
	protected function getAdd(){
		return $this->getAddByIso($_SESSION['langue']);
	}
	protected function getEdit(){
		return $this->getEditByIso($_SESSION['langue']);
	}
	protected function getAdmin(){
		return "";
	}
	public function getAddByIso($iso){
		$this->handleValidation();
		return $this->getShow();
	}
	public function getEditByIso($iso){
		return "";
	}
}
?>
