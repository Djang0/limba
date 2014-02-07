<?php
/**
 * @package limba.generators.public.properties
 * @author  Ludovic Reenaers
 * @since 24 nov. 2010
 * @link http://code.google.com/p/limba
 */

class PanelGenerator extends WrapablePropertyGenerator{
	protected function getAdd(){
		return $this->getAddByIso($_SESSION['langue']);
	}
	protected function getEdit(){
		return $this->getEditByIso($_SESSION['langue']);
	}
	protected function getShow(){
		return '{WRAP-HERE}';
	}
	protected function getAdmin(){
		return $this->getShow();
	}
	public function getAddByIso($iso){
		$ret="";
		foreach ($this->children as $child){
				$ret.=$child->getAddByIso($iso);
			}
		return $ret;
	}
	public function getEditByIso($iso){
		$ret="";
		foreach ($this->children as $child){
				$ret.=$child->getEditByIso($iso);
			}
		return $ret;
	}
}
?>