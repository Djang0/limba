<?php
/**
 * @package limba.interfaces
 * @author  Ludovic Reenaers
 * @since 16 déc. 2010
 * @link http://code.google.com/p/limba
*/
abstract class WrapablePropertyGenerator extends PropertyGenerator implements Wrapable{
	protected $children = array();
	protected $mode;
	function __construct($params, $factory,$Property,$mode='ADM'){
		parent::__construct($params, $factory, $Property);
		$this->mode = $mode;
	}
	public function setChildren($childArray){
		$bool = true;
		foreach ($childArray as $child){
			if (!is_a( $child, "Generator")){
				$bool = false;
			}
		}
		if($bool){
			$this->children = $childArray;
		}else{
			trigger_error("ERR_WRONG_KIND_OF_INSTANCE", E_USER_ERROR);
		}
	}
	public function getChildren(){
		return $this->children;
	}
	public function addChild($Child){
		if (is_a($Child, "Generator")){
			array_push($this->children, $Child);
		}else{
			trigger_error("ERR_WRONG_KIND_OF_INSTANCE", E_USER_ERROR);
		}
	}
	function setUp(){
		parent::setUp();
		$wraped = "";
		foreach ($this->children as $child){
			$wraped.=$child->dump();
		}
		$this->content = str_replace("{WRAP-HERE}",$wraped,$this->content);	
	}
	
}
?>