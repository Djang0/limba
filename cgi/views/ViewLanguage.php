<?php
/**
 * @package limba.views
 * @author  Ludovic Reenaers
 * @since 30 sept. 2010
 * @link http://code.google.com/p/limba
 */

class ViewLanguage extends View{
	function change($url){
		$this->redirect($url);
	}
}
?>
