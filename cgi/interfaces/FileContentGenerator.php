<?php
/**
 * @package limba.interfaces
 * @author  Ludovic Reenaers
 * @since 09 Fev. 2011
 * @link http://code.google.com/p/limba
 */

class FileContentGenerator extends Generator{
	protected $file;
	function __construct($params, $factory, $file){
		parent::__construct($params, $factory);
		$this->file = $file;
	}
	function setUp(){
		if(file_exists($this->file)){
			$this->content = file_get_contents($this->file)."\n";
		}else{
			$this->content = "\n";
		}
	}
	function dump(){
		$this->setUp();
		return $this->content;
	}
}