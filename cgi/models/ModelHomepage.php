<?php
/**
 * @package limba.models
 * @author  Ludovic Reenaers
 * @since 21 janv. 2009
 * @link http://code.google.com/p/limba
 */

class ModelHomepage extends Model{
	function show(){
		$factory  = new DocumentFactory($this->params,$this->factory);
		return $factory;
	}
	function admin(){
		$gen = new CategoryAdminGenerator( $this->params, $this->factory);
		return $gen->dump();
	}
}
?>
