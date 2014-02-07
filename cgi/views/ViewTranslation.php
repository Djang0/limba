<?php
/**
 * @package limba.views
 * @author  Ludovic Reenaers
 * @since 4 nov. 2010
 * @link http://code.google.com/p/limba
 */

class ViewTranslation extends View{
	function admin($page){
		$this->setContent($page);
	}
	function update($url){
		FormManager::redirectGood();
	}
	function add($page){
		$this->setContent($page);
	}
	function insert($url){
		FormManager::redirectGood();
	}
}
?>