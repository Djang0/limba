<?php
/**
 * @package limba.generators.public.components.elements
 * @author  Ludovic Reenaers
 * @since 18 juin 2009
 * @link http://code.google.com/p/limba
 */

class ThirdFailureCaptchaGenerator extends CaptchaGenerator{
	function setUp(){
		$this->content="";
		if(isset($_SESSION["failedlogin"]) && $_SESSION["failedlogin"]>2){
			parent::setUp();
		}
	}
}
?>
