<?php
/**
 * @package limba.generators.public.components.headers
 * @author  Ludovic Reenaers
 * @since 02 fev. 2009
 * @link http://code.google.com/p/limba
 */

class TitleGenerator extends Generator{
	function setUp(){
		$this->content = '<title>'.$this->params['title'].'</title>';
	}
}