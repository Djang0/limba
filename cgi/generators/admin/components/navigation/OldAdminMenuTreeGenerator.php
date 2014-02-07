<?php
/**
 * @package limba.generators.admin.components.navigation
 * @author  Ludovic Reenaers
 * @since 21 janv. 2009
 * @link http://code.google.com/p/limba
 */

class OldAdminMenuTreeGenerator extends MenuTreeGenerator{
	protected function dumpCategory($category){
		$strr=null;
		$this->lvl+=1;
		
		if($this->authorizeTreeItem($category)){
			$strr='<ul class="menu">';
			
			$label = $category->getLabel($_SESSION['langue']);
			$tooltip = $category->getTooltip($_SESSION['langue']);
			$cls = "opened";
			if($this->params['module'] == "document"){
				if($category->containsDocument((int)$this->params["currentid"])){
				}
				if($category->hasChildDocument((int)$this->params["currentid"]) || ($this->params['action']=='add' && $category->hasChildCategory((int)$this->params["targetcatid"]))){
					
					$strr.='<li class="opened"><a href="'.$_SERVER["SCRIPT_NAME"].'?/category/admin/'.$category->getId().'/'.$label.'/" title="'.$tooltip.'" alt="'.$tooltip.'">'.$label.'</a>';
					
					foreach ($category->getChildCategories() as $cat){
						$strr.=$this->dumpCategory($cat);
					}
				}else{
					$cls = "closed";
					
					$strr.='<li class"closed"><span><a href="'.$_SERVER["SCRIPT_NAME"].'?/category/admin/'.$category->getId().'/'.$label.'/" title="'.$tooltip.'" alt="'.$tooltip.'">'.$label.'</a></span>';
					
				}
				$strr.="</li></ul>";
			}elseif ($this->params['module'] == "category"){
				if((int)$this->params["currentid"] == $category->getId()){
				}
				if($category->hasChildCategory((int)$this->params["currentid"])){
					
					$strr.='<li class="opened"><a href="'.$_SERVER["SCRIPT_NAME"].'?/category/admin/'.$category->getId().'/'.$label.'/" title="'.$tooltip.'" alt="'.$tooltip.'">'.$label.'</a>';
					
					foreach ($category->getChildCategories() as $cat){
						$strr.=$this->dumpCategory($cat);
					}
				}else{
					$cls = "closed";
						
					$strr.='<li class"closed"><span><a href="'.$_SERVER["SCRIPT_NAME"].'?/category/admin/'.$category->getId().'/'.$label.'/" title="'.$tooltip.'" alt="'.$tooltip.'">'.$label.'</a></span>';
					
				}
				$strr.="</li></ul>";
			}else{
				$cls = "closed";
					
				$strr.='<li class"closed"><span><a href="'.$_SERVER["SCRIPT_NAME"].'?/category/admin/'.$category->getId().'/'.$label.'/" title="'.$tooltip.'" alt="'.$tooltip.'">'.$label.'</a></span>';
				
			}
		}

		return $strr;
	}

}
?>
