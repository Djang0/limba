<?php
/**
 * @package limba
 * @author  Ludovic Reenaers
 * @since 21 janv. 2009
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
		//put it in SERVER vars after dev?
		$obj = new ClassMapHelper();
		$pth = $obj->getLibPath($className);
	}
	if(is_null($pth)){
		$pth=str_replace('_', '/', $className).".php";
	}
	include_once($pth);
}

$control=new Controler();

//TODO: add entite.default_recording_category_id field (when recording a document for given entite, if form entite's def_record_id is null =>> system ask where to record!)
//TODO: add entite.is_static boolean field (true = contenu; false = formulaire)
?>