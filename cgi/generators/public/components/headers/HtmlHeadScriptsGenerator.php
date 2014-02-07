<?php
/**
 * @package limba.generators.public.components.headers
 * @author  Ludovic Reenaers
 * @since 2 déc. 2011
 * @link http://code.google.com/p/limba
 */

class HtmlHeadScriptsGenerator extends Generator{
	public function setUp(){
		$this->content = "";
		$this->content.='<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />'."\n";
		$this->content.='<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>'."\n";
		if($this->params['module']=='document'){
			$bean = $this->params['rootCat']->getDocument((int)$this->params['currentid']);
			$this->content.='<meta name="name" content="'.$bean->getLabel($_SESSION['langue']).'" lang="'.$_SESSION['langue'].'" />'."\n";
			$this->content.='<meta name="date" content="'.$bean->getUpdated().'" scheme="YYYY-MM-DD hh:mm:ss" lang="'.$_SESSION['langue'].'" />'."\n";
			$this->content.='<meta name="abstract" content="'.$bean->getTooltip($_SESSION['langue']).'" lang="'.$_SESSION['langue'].'" />'."\n";
			$this->content.='<meta http-equiv="last-modified" content="'.$bean->getUpdated().'" />'."\n";
		}elseif($this->params['module']=='category'){
			$bean = $this->params['rootCat']->getChildCategory((int)$this->params['currentid']);
			$this->content.='<meta name="name" content="'.$bean->getLabel($_SESSION['langue']).'" lang="'.$_SESSION['langue'].'" />'."\n";
			$this->content.='<meta name="date" content="'.$bean->getUpdated().'" scheme="YYYY-MM-DD hh:mm:ss" lang="'.$_SESSION['langue'].'" />'."\n";
			$this->content.='<meta name="abstract" content="'.$bean->getTooltip($_SESSION['langue']).'" lang="'.$_SESSION['langue'].'" />'."\n";
			$this->content.='<meta http-equiv="last-modified" content="'.$bean->getUpdated().'" />'."\n";
		}else{
			$this->content.='<meta name="name" content="'.$this->params['title'].'" lang="'.$_SESSION['langue'].'" />'."\n";
		}
		$this->content.='<meta name="classification" content="'.$this->params['translator']->META_CLASSIFICATION.'" lang="'.$_SESSION['langue'].'" />'."\n";
		$this->content.='<meta name="copyright" content="'.$this->params['translator']->META_COPYRIGHT.'" lang="'.$_SESSION['langue'].'" />'."\n";
		$this->content.='<meta name="description" content="'.$this->params['translator']->META_DESCRIPTION.'" lang="'.$_SESSION['langue'].'" />'."\n";
		$this->content.='<meta name="distribution" content="web" lang="'.$_SESSION['langue'].'" />'."\n";
		$this->content.='<meta name="expires" content="never" lang="'.$_SESSION['langue'].'" />'."\n";
		$this->content.='<meta name="generator" content="limba" lang="'.$_SESSION['langue'].'" />'."\n";
		$this->content.='<meta name="keywords" content="'.$this->params['translator']->META_KEYWORDS.'" lang="'.$_SESSION['langue'].'" />'."\n";
		$this->content.='<meta name="author" content="Ludovic Reenaers" lang="'.$_SESSION['langue'].'" />'."\n";
		$this->content.='<meta name="owner" content="Msw asbl. http://www.msw.be/" lang="'.$_SESSION['langue'].'" />'."\n";
		$this->content.='<meta name="rating" content="general" lang="'.$_SESSION['langue'].'" />'."\n";
		$this->content.='<meta http-equiv="cache-control" content="no-cache" />'."\n";
		$this->content.='<meta http-equiv="content-language" content="'.$_SESSION['langue'].'-BE" />'."\n";
		$this->content.='<meta http-equiv="expires" content="never" />'."\n";
		$this->content.='<link rel="stylesheet" href="/css/ext/tripoli.simple.css" type="text/css" media="screen" />'."\n";
		$this->content.='<!--[if IE]><link rel="stylesheet" href="/css/ext/tripoli.simple.ie.css" type="text/css" media="screen" /><![endif]-->'."\n";
		$this->content.='<link rel="stylesheet" href="/css/ergonomic.css" type="text/css" media="screen" />'."\n";
		$this->content.='<!--[if IE]><link rel="stylesheet" href="/css/ergonomic.ie.css" type="text/css" media="screen" /><![endif]-->'."\n";
		$this->content.='<link rel="stylesheet" href="/css/ergonomic.content.css" type="text/css" media="screen" />'."\n";
		$this->content.='<!--[if IE]><link rel="stylesheet" href="/css/ergonomic.content.ie.css" type="text/css" media="screen" /><![endif]-->'."\n";
		$this->content.='<link rel="stylesheet" href="/css/ergonomic.custom.css" type="text/css" media="screen" />'."\n";
		$this->content.='<!--[if IE]><link rel="stylesheet" href="/css/ergonomic.custom.ie.css" type="text/css" media="screen" /><![endif]-->'."\n";
		$this->content.='<link media="screen" rel="stylesheet" type="text/css" href="/css/ext/datatable1.css" />'."\n";
		$this->content.='<link media="screen" rel="stylesheet" type="text/css" href="/css/ext/datatable2.css" />'."\n";
		$this->content.='<link href="/css/ext/datepicker.css" rel="stylesheet" type="text/css"/>'."\n";
		$this->content.='<link rel="icon" type="image/png" href="/img/user/favicon.png"/>'."\n";
		$this->content.='<script type="text/javascript" src="/js/ext/jquery.min.js"></script>'."\n";
		$this->content.='<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=fr"></script>'."\n";
		$this->content.='<script type="text/javascript" src="/js/common.js"></script>'."\n";
		$this->content.='<script type="text/javascript" src="/external/ckeditor/ckeditor.js"></script>'."\n";
		$this->content.='<script type="text/javascript" src="/js/ext/datepicker.js"></script>'."\n";
		$this->content.='<script type="text/javascript" src="/js/ext/dataTables.jquery.js"></script>'."\n";
		$this->content.='<script src="/js/ext/flir.js" type="text/javascript"></script>'."\n";
		$this->content.='<script src="/external/syntaxhighlighter/scripts/shCore.js" type="text/javascript"></script>'."\n";
		$this->content.='<script type="text/javascript" src="/external/syntaxhighlighter/scripts/shBrushPhp.js"></script>'."\n";
		$this->content.='<link href="/external/syntaxhighlighter/styles/shCore.css" rel="stylesheet" type="text/css"/>'."\n";
		$this->content.='<link href="/external/syntaxhighlighter/styles/shThemeDefault.css" rel="stylesheet" type="text/css"/>'."\n";
		$this->content.='<script type="text/javascript" charset="utf-8">'."\n";
		$this->content.='SyntaxHighlighter.all();'."\n";
		$this->content.='</script>'."\n";
	}
}
?>