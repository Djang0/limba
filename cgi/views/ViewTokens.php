<?php
/**
 * @package limba.views
 * @author  Ludovic Reenaers
 * @since 19 mai. 2011
 * @link http://code.google.com/p/limba
 */

class ViewTokens extends View{
	function admin($page){
		$this->setContent($page);
	}
	function edit($page){
		$this->setContent($page);
	}
	function add($page){
		$this->setContent($page);
	}
	function update($url){
		FormManager::redirectGood();
	}
	function insert($url){
		FormManager::redirectGood();
	}
}
?>