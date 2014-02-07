<?php
/**
 * @package limba.generators.public.components.navigation
 * @author  Ludovic Reenaers
 * @since 21 janv. 2009
 * @link http://code.google.com/p/limba
 */
class SingleCategoryMenuTreeGenerator extends MenuTreeGenerator{
	protected function dumpCategory($category){
		$strr="";
		if($this->authorizeTreeItem($category)){
			$strr.='<h3><a href="'.$_SERVER['SCRIPT_NAME'].'?/homepage/show/" title="'.$category->getTooltip($_SESSION['langue']).'">'.$category->getLabel($_SESSION['langue']).'</a></h3>';
		}
		$strr .='<ul>';
		foreach ($category->getChildDocuments() as $Doc){
			if($this->authorizeTreeItem($Doc)){	
				if($Doc->getId()==(int)$this->params['currentid']){
					$strr.='<li><span class="current" title="'.$Doc->getTooltip($_SESSION['langue']).'">'.$Doc->getLabel($_SESSION['langue']).'</span></li>';
				}else{
					$strr.='<li><a href="'.$_SERVER['SCRIPT_NAME'].'?/document/show/'.$Doc->getId().'/'.$Doc->getLabel($_SESSION['langue']).'/" title="'.$Doc->getTooltip($_SESSION['langue']).'">'.$Doc->getLabel($_SESSION['langue']).'</a></li>';
				}
			}
		}
		$strr.='</ul>';
		return $strr;
	}
}