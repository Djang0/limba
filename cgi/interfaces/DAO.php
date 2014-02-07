<?php
/**
 * @package limba.interfaces
 * @author  Ludovic Reenaers
 * @since 24 janv. 2009
 * @link http://code.google.com/p/limba
 */
class DAO{
	protected $pdo;
	protected $factory;
	function __construct($pdo,$factory){
		$this->pdo = $pdo;
		$this->factory = $factory;
	}
}
?>