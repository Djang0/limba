<?php
/**
 * @package limba.generators.public.components.elements
 * @author  Ludovic Reenaers
 * @since 17 mar. 2011
 * @link http://code.google.com/p/limba
 */
class FaceBookGroupGenerator extends Generator{
	function setUp(){
		$this->content='<a href="http://www.facebook.com/home.php?sk=group_171842006202090&ref=ts#!/home.php?sk=group_171842006202090" title="'.$this->params['translator']->fbgrp.'"><img src="/img/user/fb_large.jpg"/></a>';
	}
}