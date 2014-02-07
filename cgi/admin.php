<?php
/**
 * @package limba
 * @author  Ludovic Reenaers
 * @since fev. 2011
 * @link http://code.google.com/p/limba
 */

session_start();

function __autoload($className)
{

	loadClass($className);
}
function loadClass($className) {
	$pth= null;
	if ($className == "PathFactory"){
		$pth = 'factories/PathFactory.php';
	}elseif ($className=='ClassMapHelper'){
		$pth = 'util/ClassMapHelper.php';
	}else{
		$obj = new ClassMapHelper();
		$pth = $obj->getLibPath($className);
	}
	if(is_null($pth)){
		$pth=str_replace('_', '/', $className).".php";
	}
	
	include_once($pth);
}
$control=new Controler("ADMIN");
?>