<?php
/**
 * @package limba.views
 * @author  Ludovic Reenaers
 * @since 02 mar. 2011
 * @link http://code.google.com/p/limba
 */

class ViewAdmin extends View{
	function useredit($generator){
		$this->setContent($generator->dump());
	}
	function useradd($generator){
		$this->setContent($generator->dump());
	}
	function userupdate($url){
		FormManager::redirectGood();
	}
	function userinsert($url){
		FormManager::redirectGood();
	}
}
?>