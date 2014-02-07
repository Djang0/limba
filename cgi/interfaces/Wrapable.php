<?php
/**
 * @package limba.interfaces
 * @since 11 juin 2009
 * @author  Ludovic Reenaers
 * @link http://code.google.com/p/limba
 */
interface Wrapable{
	public function setChildren($childArray);
	public function getChildren();
	public function addChild($Child);
}
?>
