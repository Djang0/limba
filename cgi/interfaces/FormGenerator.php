<?php
/**
 * @package limba.interfaces
 * @author  Ludovic Reenaers
 * @since 15 déc. 2010
 * @link http://code.google.com/p/limba
*/
abstract class FormGenerator extends WrapableGenerator{
	public function __construct($params,$factory){
		parent :: __construct($params,$factory);
	}
}
?>