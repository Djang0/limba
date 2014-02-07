<?php
/**
 * @package limba.views
 * @author  Ludovic Reenaers
 * @since 20 oct. 2010
 * @link http://code.google.com/p/limba
 */

class ViewLogin extends View{
	function remind($bool){
		FormManager::redirectGood();
	}
	function show($generator){
		$this->setContent($generator->dump());
	}
	function forgot($generator){
		$this->setContent($generator->dump());
	}
	function notfound($whatever){
		$this->setContent($this->params['translator']->notfound);
	}
	function mailsent($whatever){
		$this->setContent($this->params['translator']->mailsent);
	}
}
?>