<?php
/**
 * @package limba.views
 * @author  Ludovic Reenaers
 * @since 11 mar. 2011
 * @link http://code.google.com/p/limba
 */

class ViewContact extends View{
	function add($factory){
		$this->setContent($factory->dump());
	}
	function done($str){
		$this->setContent($str);
	}
	function insert($url){
		FormManager::redirectGood();
	}
}