<?php
/**
 * @package limba.views
 * @author  Ludovic Reenaers
 * @since 7 juil. 2011
 * @link http://code.google.com/p/limba
 */
class ViewAjax extends View{
	function tree($str){
		$this->setContent($str);
	}
	function auto($str){
		$this->setContent($str);
	}
}
?>