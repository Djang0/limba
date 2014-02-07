<?php
/**
 * @package limba.views
 * @author  Ludovic Reenaers
 * @since 23 sept. 2010
 * @link http://code.google.com/p/limba
 */

class ViewCategory extends View{
	function show($generator){
		$this->setContent($generator->dump());
	}
	function edit($page){
		$this->setContent($page);
	}
	function admin($page){
		$this->setContent($page);
	}
	function add($page){
		$this->setContent($page);
	}
	function insert($url){
		FormManager::redirectGood();
	}
	function update($url){
		FormManager::redirectGood();
	}
}
?>
