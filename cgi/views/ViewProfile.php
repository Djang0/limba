<?php
/**
 * @package limba.views
 * @author  Ludovic Reenaers
 * @since 02 mar. 2011
 * @link http://code.google.com/p/limba
 */

class ViewProfile extends View{
	function add($page){
		$this->setContent($page);
	}
	function admin($page){
		$this->setContent($page);
	}
	function edit($generator){
		$this->setContent($generator->dump());
	}
	function insert($url){
		FormManager::redirectGood();
	}
	function update($url){
		FormManager::redirectGood();
	}
}
?>