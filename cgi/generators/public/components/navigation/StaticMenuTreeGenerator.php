<?php
/**
 * @package limba.generators.public.components.navigation
 * @author  Ludovic Reenaers
 * @since 21 janv. 2009
 * @link http://code.google.com/p/limba
 */
class StaticMenuTreeGenerator extends MenuTreeGenerator{
	protected function dumpCategory($category){
		$this->lvl+=1;
		$strr=null;
		if(!$category->isRoot() && $this->authorizeTreeItem($category)){
			if($this->lvl<=2){
				$liCls = "headerbar";
				$label = $category->getLabel($_SESSION['langue']);
				$tooltip = $category->getTooltip($_SESSION['langue']);
			
				if (((int)$this->params["currentid"] == $category->getId() && strtolower($this->params["module"])=="category") || ($category->containsDocument((int)$this->params["currentid"]) && strtolower($this->params["module"])=="document")) {
					
					
					$strr.='<h3 class="'.$liCls.'">'.$label.'</h3>';
				}elseif(($category->hasChildCategory((int)$this->params["currentid"]) && strtolower($this->params["module"])=="category")||($category->hasChildDocument((int)$this->params["currentid"]) &&  strtolower($this->params["module"]=="document"))){
					
					
					
					$strr.='<h3 class="'.$liCls.'"><a href="'.$_SERVER['SCRIPT_NAME'].'?/category/show/'.$category->getId().'/'.$label.'/" title="'.$tooltip.'" alt="'.$tooltip.'">'.$label.'</a></h3>';
					
				}elseif(strtolower($this->params["module"])<>"category" && strtolower($this->params["module"])<>"document"){
					
					$strr.='<h3 class="'.$liCls.'"><a href="'.$_SERVER['SCRIPT_NAME'].'?/category/show/'.$category->getId().'/'.$label.'/" title="'.$tooltip.'" alt="'.$tooltip.'">'.$label.'</a></h3>';
					
				}else{
					
					$strr.='<h3 class="'.$liCls.'"><a href="'.$_SERVER['SCRIPT_NAME'].'?/category/show/'.$category->getId().'/'.$label.'/" title="'.$tooltip.'" alt="'.$tooltip.'">'.$label.'</a></h3>';
					
				}
					$strr.="<ul>";
					$tmp = $this->lvl;
					foreach ($category->getChildCategories() as $cat){
						
						$strr.=$this->dumpCategory($cat);
						$this->lvl = $tmp;
					}
					$strr.="</ul>";
			}elseif($this->lvl == $this->maxRecurse){
				$label = $category->getLabel($_SESSION['langue']);
				$tooltip = $category->getTooltip($_SESSION['langue']);
			
				if (((int)$this->params["currentid"] == $category->getId() && strtolower($this->params["module"])=="category") || ($category->containsDocument((int)$this->params["currentid"]) && strtolower($this->params["module"])=="document")) {
					
					$strr.='<li><span class="current">'.$label.'</span></li>';
				}elseif(($category->hasChildCategory((int)$this->params["currentid"]) && strtolower($this->params["module"])=="category")||($category->hasChildDocument((int)$this->params["currentid"]) &&  strtolower($this->params["module"]=="document"))){
					
					$strr.='<li><span class="current">'.$label.'</span></li>';
				}elseif(strtolower($this->params["module"])<>"category" && strtolower($this->params["module"])<>"document"){
					
					$strr.='<li><a href="'.$_SERVER['SCRIPT_NAME'].'?/category/show/'.$category->getId().'/'.$label.'/" title="'.$tooltip.'" alt="'.$tooltip.'">'.$label.'</a></li>';
					
				}else{
					
					$strr.='<li><a href="'.$_SERVER['SCRIPT_NAME'].'?/category/show/'.$category->getId().'/'.$label.'/" title="'.$tooltip.'" alt="'.$tooltip.'">'.$label.'</a></li>';
					
				}
				
					$tmp = $this->lvl;
					foreach ($category->getChildCategories() as $cat){
						
						$strr.=$this->dumpCategory($cat);
						$this->lvl = $tmp;
					}
			}
		}
		else{
			if(($category->hasChildCategory((int)$this->params["currentid"]) && strtolower($this->params["module"]=="category"))|| ($category->hasChildDocument((int)$this->params["currentid"]) && strtolower($this->params["module"]=="document"))||$this->lvl == 1){
				$tmp = $this->lvl;
				foreach ($category->getChildCategories() as $cat){	
					$strr.=$this->dumpCategory($cat);
					$this->lvl = $tmp;
				}		
			}
		}
		return $strr;
	}
}
?>
