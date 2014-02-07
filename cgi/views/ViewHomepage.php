<?php
/**
 * @package limba.views
 * @author  Ludovic Reenaers
 * @since 21 janv. 2009
 * @link http://code.google.com/p/limba
 */

class ViewHomepage extends View{
	function show($factory){
		$this->setContent($factory->dump());
	}
	function admin($page){
		$this->setContent($page);
	}
}
?>
