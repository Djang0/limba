<?php
/**
 * @package limba.generators.public.components.elements
 * @author  Ludovic Reenaers
 * @since 22 mar. 2011
 * @link http://code.google.com/p/limba
 */
class IframGenerator extends Generator{
	private $target;
	function __construct($params, $factory,$target){
		parent::__construct($params, $factory);
		$this->target = $target;
	}
	
	function setUp(){
		//$this->content = '<iframe name="embeddedee" id="embeddede" SRC="/embed.php?'.$this->target.'" scrolling="no" height="10px" width="100%" FRAMEBORDER="no"></iframe>';
		//$this->content = file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/embed.php?'.$this->target);
		$_SESSION['wrapperurl']=$_SERVER['REQUEST_URI'];
		$this->content.='<script type="text/javascript">';
		//$this->content.='jQuery.ajaxSetup ({cache: false});';
		$this->content.='url = "http://'.$_SERVER['HTTP_HOST'].'/embed.php?'.$this->target.'";';
		$this->content.='ajaxLoad(url,\'listing\',function() {jQuery(\'#dynTab\').dataTable({"oLanguage": {"sUrl": "/js/lang/dynTable_'.strtoupper($_SESSION['langue']).'.txt"}});});';
		//$this->content.='jQuery("#data").ready(function(){jQuery("#data").html(ajax_load).load(loadUrl, function() {jQuery(\'#dynTab\').dataTable({"oLanguage": {"sUrl": "/js/lang/dynTable_'.strtoupper($_SESSION['langue']).'.txt"}});});});';
		$this->content.='</script>'."\n";
		
	}
}

?>