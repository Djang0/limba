<?php
/**
 * @package limba.views
 * @author  Ludovic Reenaers
 * @since 23 sept. 2010
 * @link http://code.google.com/p/limba
 */

class ViewDocument extends View{
	function show($factory){
		$this->setContent($factory->dump());
	}
	function admin($factory){
		$this->setContent($factory->dump());
	}
	function edit($factory){
		$this->setContent($factory->dump());
	}
	function add($factory){
		$this->setContent($factory->dump());
	}
	function update($url){
		FormManager::redirectGood();
	}
	function insert($url){
		FormManager::redirectGood();
	}
}
?>