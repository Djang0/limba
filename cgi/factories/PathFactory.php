<?php
/**
 * @package limba.factories
 * @author  Ludovic Reenaers
 * @since 21 oct. 2010
 * @link http://code.google.com/p/limba
 */

class PathFactory{
	public static function getConfigPath(){
		
	//	$srvtab = explode("/",$_SERVER['DOCUMENT_ROOT']);
	//	$cpt= count($srvtab);
		//if($srvtab[$cpt-1]==''){
			//unset($srvtab[$cpt-1]);
			//$cpt= count($srvtab);
		//}
		//if($_SERVER['DOCUMENT_ROOT'][1]==':'){
			//$xmlfile='';
		//}else{
			//$xmlfile='/';
		//}
		//foreach ($srvtab as $itm){
			//if($itm <>'' && $itm<>$srvtab[$cpt-1]){
				//$xmlfile = $xmlfile.$itm.'/';
			//}elseif ($itm==$srvtab[$cpt-1]){
				//$xmlfile = $xmlfile.'config/';
		//	}
		//}
		return $_SERVER["conf_path"];
	}

}
?>