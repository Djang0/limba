<?php
/**
 * @package limba.interfaces
 * @since 11 juin 2009
 * @author  Ludovic Reenaers
 * @link http://code.google.com/p/limba
 */
abstract class Generator{
	protected $params;
	protected $content="";
	protected $Factory = null;
	function __construct($params,$factory){
		$this->params=$params;
		$this->Factory = $factory;
	}
	function getParams(){
		return $this->params;
	} 
	function dump(){
		$this->setUp();
		return $this->content;
	}
	abstract function setUp();
}
?>
