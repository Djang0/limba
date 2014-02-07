<?php
/**
 * @package limba.models
 * @author  Ludovic Reenaers
 * @since 02 mar. 2011
 * @link http://code.google.com/p/limba
 */

class ModelFiles extends Model{
	function show(){
		$page = '<iframe width="100%" height="600px" src="http://'.$_SERVER['SERVER_NAME'].'/external/kcfinder/browse.php?type=files&lang=fr\">';
		return $page;
		
	}
}
?>