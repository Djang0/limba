<?php
/**
 * @package limba.generators.admin.components.headers
 * @author  Ludovic Reenaers
 * @since 10 Fev. 2010
 * @link http://code.google.com/p/limba
 */

class HtmlHeadAdminScriptsGenerator extends Generator{
	public function setUp(){
		$this->content = "";
		$this->content.='<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />'."\n";
		$this->content.='<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>'."\n";
		$this->content.='<script type="text/javascript" src="/js/ext/jquery.min.js"></script>'."\n";
		$this->content.='<script type="text/javascript" src="/js/ext/jquery.easing.js"></script>'."\n";
		$this->content.='<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=fr"></script>'."\n";
		$this->content.='<script type="text/javascript" src="/external/ckeditor/ckeditor.js"></script>'."\n";
		$this->content.='<!--  toto 3 -->';
		$this->content.='<script type="text/javascript" src="/js/ext/datepicker.js"></script>'."\n";
		$this->content.='<!--  toto 1 -->';
		$this->content.='<script type="text/javascript" src="/js/common.js"></script>'."\n";
		$this->content.='<!--  toto 2 -->';
		$this->content.='<script type="text/javascript" src="/external/jqueryFileTree/jqueryFileTree.js"></script>'."\n";
		$this->content.='<script type="text/javascript" src="/js/ext/dataTables.jquery.js"></script>'."\n";
		if(file_exists($_SERVER{'DOCUMENT_ROOT'}."/js/".$this->params["module"].".js")){
			$this->content.='<script type="text/javascript" src="/js/'.$this->params["module"].'.js"></script>'."\n";
		}
		$this->content.='<link media="screen" rel="stylesheet" type="text/css" href="/css/ext/tripoli.simple.css" />'."\n";
		$this->content.='<!--[if IE]><link media="screen" rel="stylesheet" type="text/css" href="/css/ext/tripoli.simple.ie.css"/><![endif]-->'."\n";
		if(file_exists($_SERVER{'DOCUMENT_ROOT'}."/css/".$this->params["module"].".css")){
			$this->content.='<link media="screen" rel="stylesheet" type="text/css" href="/css/'.$this->params["module"].'.css" />'."\n";
		}
		$this->content.='<link href="/css/ext/google.default.css" rel="stylesheet" type="text/css" />'."\n";
		$this->content.='<link media="screen" rel="stylesheet" type="text/css" href="/css/admin.css" />'."\n";
		$this->content.='<link media="screen" rel="stylesheet" type="text/css" href="/css/ext/datatable1.css" />'."\n";
		$this->content.='<link media="screen" rel="stylesheet" type="text/css" href="/external/jqueryFileTree/jqueryFileTree.css" />'."\n";
		$this->content.='<link media="screen" rel="stylesheet" type="text/css" href="/css/ext/datatable2.css" />'."\n";
		$this->content.='<!--[if IE]><link media="screen" rel="stylesheet" type="text/css" href="/css/admin.ie.css"/><![endif]-->'."\n";
		$this->content.='<link href="/css/ext/datepicker.css" rel="stylesheet" type="text/css"/>'."\n";
		$this->content.='<link rel="icon" type="image/png" href="/img/limba/favicon.png"/>'."\n";
		$mod = $this->params['module'];
		$act = $this->params['action'];
		if($_SERVER['SCRIPT_NAME']== '/admin.php'){
			$ctx = 'adm';
		}else{
			$ctx = "n";
		}
		$curid = $this->params['currentid'];
		$this->content.=<<<EOD
	<script type="text/javascript"> 
			
			$(document).ready( function() {
				$('#fileTree').fileTree({ root: 'demo/', script: '/embed.php?/ajax/tree/$mod/$act/$curid/$ctx/', folderEvent: 'click', expandSpeed: 750, collapseSpeed: 750, expandEasing: 'easeOutBounce', collapseEasing: 'easeOutBounce', loadMessage: 'Loading...' }, function(file) {document.location.href = file;});});
		</script>
EOD;
	}
}
?>