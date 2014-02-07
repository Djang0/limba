<?php
/**
 * @package limba.generators.public.components.navigation
 * @author  Ludovic Reenaers
 * @since 21 janv. 2009
 * @link http://code.google.com/p/limba
 */

class DynamicMenuTreeGenerator extends MenuTreeGenerator{
	protected function dumpCategory($category){
		$strr=null;
		$this->lvl+=1;
		if($this->authorizeTreeItem($category)){
			$strr='<ul class="menu">';			
			$label = $category->getLabel($_SESSION['langue']);
			$tooltip = $category->getTooltip($_SESSION['langue']);
			$cls = "opened";
			if (((int)$this->params["currentid"] == $category->getId() && strtolower($this->params["module"])=="category") || ($category->containsDocument((int)$this->params["currentid"]) && strtolower($this->params["module"])=="document")) {
			}elseif(strtolower($this->params["module"])<>"category" && strtolower($this->params["module"])<>"document"){
				$cls = "closed";
			}
			if(($category->hasChildCategory((int)$this->params["currentid"]) && strtolower($this->params["module"]=="category"))|| ($category->hasChildDocument((int)$this->params["currentid"]) && strtolower($this->params["module"]=="document"))){
				$strr.='<li class="opened"><a href="'.$_SERVER["SCRIPT_NAME"].'?/category/show/'.$category->getId().'/'.$label.'/" title="'.$tooltip.'" alt="'.$tooltip.'">'.$label.'</a>';
				foreach ($category->getChildCategories() as $cat){
					$strr.=$this->dumpCategory($cat);
				}
			}else{
				$cls = "closed";					
				$strr.='<li class"closed"><span><a href="'.$_SERVER["SCRIPT_NAME"].'?/category/show/'.$category->getId().'/'.$label.'/" title="'.$tooltip.'" alt="'.$tooltip.'">'.$label.'</a></span>';
			}
			$strr.="</li></ul>";
		}
		return $strr;
	}
	

}
?>
