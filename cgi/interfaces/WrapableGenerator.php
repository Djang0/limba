<?php
/**
 * @package limba.interfaces
 * @author  Ludovic Reenaers
 * @since 24 nov. 2010
 * @link http://code.google.com/p/limba
*/
abstract class WrapableGenerator extends Generator implements Wrapable{
	protected $children = array();
	function __construct($params, $factory){
		parent::__construct($params, $factory);
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
		$wraped = "";
		foreach ($this->children as $child){
			$wraped.=$child->dump();
		}
		$this->content = str_replace("{WRAP-HERE}",$wraped,$this->content);
	}
}
?>