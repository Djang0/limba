<?php
/**
 * @package limba.generators.public.components.navigation
 * @author  Ludovic Reenaers
 * @since 21 janv. 2009
 * @link http://code.google.com/p/limba
 */

class JqueryMenuTreeGenerator extends MenuTreeGenerator{

	protected function dumpCategory($treeItem){
		$this->lvl+=1;
		$strr="";
		if($this->params["callerctx"] == "adm"){
			$act = "admin";
			$scr = "/admin.php";
		}else{
			$scr = "/index.php";
			$act= "show";
		}
		if(is_a($treeItem, 'Category')){
			if($this->authorizeTreeItem($treeItem)){
				$label = $treeItem->getLabel($_SESSION['langue']);
				$tooltip = $treeItem->getTooltip($_SESSION['langue']);
				$strr .= "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
				if( $treeItem->getId() == (int)$this->params["callerid"] && strtolower($this->params["callermodule"])=="category"){
					$strr .= "<li class=\"directory expanded\"><a href=\"".$scr.'?/category/'.$act.'/'.$treeItem->getId().'/'.$label."/\" rel=\"".$scr.'?/category/'.$act.'/'.$treeItem->getId().'/'.$label."/\" alt=\"".$tooltip."\" title=\"".$tooltip."\"><span  class=\"selected\">".$label."</span></a>";
					$strr.= "<ul class=\"jqueryFileTree\">";
					foreach($treeItem->getChildCategories() as $Cat){
						$strr .= $this->dumpCategory($Cat);
					}
					foreach($treeItem->getChildDocuments() as $Doc){
						$strr .= $this->dumpCategory($Doc);
					}
					$strr.= "</ul></li>";
				}elseif( ( strtolower($this->params["callermodule"])=="category" && $treeItem->hasChildCategory((int)$this->params["callerid"]) ) || ( strtolower($this->params["callermodule"])=="document" && $treeItem->hasChildDocument((int)$this->params["callerid"]) ) ){
					$strr .= "<li class=\"directory expanded\"><a href=\"".$scr.'?/category/'.$act.'/'.$treeItem->getId().'/'.$label."/\" alt=\"".$tooltip."\" title=\"".$tooltip."\" rel=\"".$scr.'?/category/'.$act.'/'.$treeItem->getId().'/'.$label."/\">".$label."</a>";
					$strr.= "<ul class=\"jqueryFileTree\">";
					foreach($treeItem->getChildCategories() as $Cat){
						$strr .= $this->dumpCategory($Cat);
					}
					foreach($treeItem->getChildDocuments() as $Doc){
						$strr .= $this->dumpCategory($Doc);
					}
					$strr.= "</ul></li>";
				}else{
					$strr .= "<li class=\"directory collapsed\"><a href=\"".$scr.'?/category/'.$act.'/'.$treeItem->getId().'/'.$label."/\" rel=\"".$scr.'?/category/'.$act.'/'.$treeItem->getId().'/'.$label."/\" alt=\"".$tooltip."\" title=\"".$tooltip."\">".$label."</a></li>";
				}
				$strr .= "</ul>";
			}
		}elseif(is_a($treeItem, 'Document')){
			if($this->authorizeTreeItem($treeItem)){
				$label = $treeItem->getLabel($_SESSION['langue']);
				$tooltip = $treeItem->getTooltip($_SESSION['langue']);
				if( $treeItem->getId() == (int)$this->params["callerid"] && strtolower($this->params["callermodule"])=="document"){
					$strr .= "<li class=\"file ext_txt\"><a href=\"".$scr.'?/document/'.$act.'/'.$treeItem->getId().'/'.$label."/\" rel=\"".$scr.'?/document/'.$act.'/'.$treeItem->getId().'/'.$label."/\" alt=\"".$tooltip."\" title=\"".$tooltip."\"> <span  class=\"selected\">".$label."</span></a></li>";
				}else{
					$strr .= "<li class=\"file ext_txt\"><a href=\"".$scr.'?/document/'.$act.'/'.$treeItem->getId().'/'.$label."/\" rel=\"".$scr.'?/document/'.$act.'/'.$treeItem->getId().'/'.$label."/\" alt=\"".$tooltip."\" title=\"".$tooltip."\"> ".$label."</a></li>";
				}
			}
		}
		
		return $strr;
	}
}