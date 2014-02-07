<?php
/**
 * @package limba.views
 * @author  Ludovic Reenaers
 * @since 30 sept. 2010
 * @link http://code.google.com/p/limba
 */

class ViewLangs extends View{
	function admin($data){
		$this->setContent($data);
	}
	function add($data){
		$this->setContent($data);
	}
	function edit($data){
		$this->setContent($data);
	}
	function insert($data){
		FormManager::redirectGood();
	}
	function update($data){
		FormManager::redirectGood();
	}	
}
?>