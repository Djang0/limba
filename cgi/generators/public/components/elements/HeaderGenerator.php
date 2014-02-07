<?php
/**
 * @package limba.generators.public.components.elements
 * @author  Ludovic Reenaers
 * @since 13 janv. 2011
 * @link http://code.google.com/p/limba
 */
class HeaderGenerator extends Generator{
	function setUp(){
		$this->content='<a href="'.$this->params['config']->siteurl.'"><img src="/img/limba/header_'.$_SESSION['langue'].'.png"/></a>';
	}
}
?>