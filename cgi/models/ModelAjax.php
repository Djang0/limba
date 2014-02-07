<?php
/**
 * @package limba.models
 * @author  Ludovic Reenaers
 * @since 7 juil. 2011
 * @link http://code.google.com/p/limba
 */
class ModelAjax extends Model{
	function tree(){
		$gen = new JqueryMenuTreeGenerator($this->params,$this->factory);
		return $gen->dump();
	}
	function auto(){
		$gen = new AutoCompleteGenerator($this->params,$this->factory);
		return $gen->dump();
	}
}
?>