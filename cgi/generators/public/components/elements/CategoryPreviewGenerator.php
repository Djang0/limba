<?php
/**
 * @package limba.generators.public.components.elements
 * @author  Ludovic Reenaers
 * @since 22 mars 2011
 * @link http://code.google.com/p/limba
 */
 class CategoryPreviewGenerator extends Generator{
 	private $bean;
	function __construct($params, $factory, $bean){
		parent::__construct($params, $factory);
		$this->bean = $bean;
	}
	function setUp(){
		$cats = $this->bean->getChildCategories();
		$docs = $this->bean->getChildDocuments();
		if(count($cats)>0){
			foreach ($cats as $Cat){
				$this->content .= '<div class="catsumm"><a href="'.$_SERVER['SCRIPT_NAME'].'?/category/show/'.$Cat->getId().'/" alt="'.$Cat->getTooltip($_SESSION['langue']).'" title="'.$Cat->getTooltip($_SESSION['langue']).'">'.$Cat->getLabel($_SESSION['langue']).'</a></div>';					
			}
		}elseif (count($docs)>0){
			foreach ($docs as $Doc){
				$this->content .= '<div class="docsumm"><a href="'.$_SERVER['SCRIPT_NAME'].'?/document/show/'.$Doc->getId().'/" alt="'.$Doc->getTooltip($_SESSION['langue']).'" title="'.$Doc->getTooltip($_SESSION['langue']).'">'.$Doc->getLabel($_SESSION['langue']).'</a></div>';		
			}
		}
	}
}
?>