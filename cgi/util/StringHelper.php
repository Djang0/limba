<?php
/**
 * @package limba.util
 * @author  Ludovic Reenaers
 * @since 30 mar. 2011
 * @link http://code.google.com/p/limba
 */

class StringHelper{

	public static function escapeSql($str,$allowHtml=false){
	
        $search=array("\\","\0","\n","\r","\x1a","'",'"');
        $replace=array("\\\\","\\0","\\n","\\r","\Z","\'",'\"');
        if($allowHtml){
        	$ret = str_replace($search,$replace,$str);
        }else{
        	$ret = htmlspecialchars(str_replace($search,$replace,$str));
        }
        return $ret;
      
	}
	public static function get_include_contents($filename) {
	    if (is_file($filename)) {
	        ob_start();
	        include $filename;
	        $contents = ob_get_contents();
	        ob_end_clean();
	        return $contents;
	    }
	    return false;
	}
	public static function w3cDate($time) { 
	    $offset = date("O",time()); 
	    return str_replace(' ','T',$time).substr($offset,0,3).":".substr($offset,-2); 
	} 
}