<?php
/**
 * @package limba.generators.public.components.navigation
 * @author  Ludovic Reenaers
 * @since 20 avril 2011
 * @link http://code.google.com/p/limba
 */
class SitemapGenerator extends MenuTreeGenerator{
	private $xml;
	private $baseurl;
	function __construct($params,$factory){
		parent::__construct($params,$factory);
		$this->xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" standalone="yes"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');
		$this->baseurl = $this->params['config']->siteurl.$this->params['config']->controler;
	}
	function addUrl($element){
		if($this->authorizeTreeItem($element)){
			$urlnode = $this->xml->addChild('url');
			if(!is_null($element->getAlternate()) && trim($element->getAlternate())<>''){
				$url = $this->baseurl.'?'.$element->getAlternate();
			}else{
				if(is_a($element,'Category')){
					$url = $this->baseurl.'?/category/show/'.$element->getID().'/'.$element->getLabel($_SESSION['langue']);
				}elseif (is_a($element,'Document')){
					$url = $this->baseurl.'?/category/show/'.$element->getID().'/'.$element->getLabel($_SESSION['langue']);
				}
			}
			$loc = $urlnode->addChild('loc',$url);
			$lastmod = $urlnode->addChild('lastmod', StringHelper::w3cDate($element->getUpdated()));
		}
	}
	function recordCat($cat){
		foreach ($cat->getChildCategories() as $Cat){
			$this->addUrl($Cat);
			$this->recordCat($Cat);
		}
		foreach ($cat->getChildDocuments() as $Doc){
			$this->addUrl($Doc);
		}
	}
	function dumpCategory($cat){
		$this->addUrl($cat);
		$this->recordCat($cat);
		return $this->xml->asXML();
	}
}
?>