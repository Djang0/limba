<?php
/**
 * @package limba.generators.admin.components.navigation
 * @author  Ludovic Reenaers
 * @since 21 janv. 2009
 * @link http://code.google.com/p/limba
 */

class AdminBreadCrumbGenerator extends Generator{
	private $catPath;
	protected $page;
	private $rootCat;
	function __construct($params, $factory){
		parent::__construct($params, $factory);
		$this->rootCat = $this->params['rootCat'];
	}
	public function setUp(){
		$this->catPath = array();
		$this->content ="";
		if($this->params["module"]<>"homepage" && $this->params["module"]<>"language"){
			$this->content = '<div id="BreadCrumb"><ul class="crumbs">';
			$home = $this->params['translator']->home;
			//$this->content.='<li><a href="'.$_SERVER['SCRIPT_NAME'].'?/homepage/admin/" title="'.$home.'" alt="'.$home.'">'.ucfirst($home).'</a></li>';
			if ($this->params["module"]=="document" || $this->params["module"]=="category"){
				$this->content.=$this->browseCategories($this->params['rootCat']);
				if ($this->params["module"]=="document"){
					$this->content.='<li>'.$this->params["title"]."</li>";
				}
			}else{
				$this->content.='<li>'.$this->params["title"]."</li>";
			}
			$this->content .= '</ul></div>';
		}
	}
	private function browseCategories($cat){
		$page='';
		if($this->params["module"]=="category"){
			if($cat->hasChildCategory((int)$this->params["currentid"])){
				array_push($this->catPath, $cat->getId());
				$info = $cat->getLabel($_SESSION['langue']);
				if((int)$this->params["currentid"]== $cat->getId()){
					$page.= '<li>'.$info."</li>";
				}else{					
					$page.= '<li><a href="'.$_SERVER['SCRIPT_NAME'].'?/category/admin/'.$cat->getId().'/'.$info.'/" title="'.$cat->getTooltip($_SESSION['langue']).'" alt="'.$cat->getTooltip($_SESSION['langue']).'">'.$info.'</a></li>';
				}	
				foreach ($cat->getChildCategories() as $tmpcat){
					$page.=$this->browseCategories($tmpcat);
				}
			}
		}elseif ($this->params["module"]=="document"){
			if($cat->hasChildDocument((int)$this->params["currentid"])){
				array_push($this->catPath, $cat->getId());
				if(!$cat->isRoot()){
					$info = $cat->getLabel($_SESSION['langue']);			
					$page.= '<li><a href="'.$_SERVER['SCRIPT_NAME'].'?/category/admin/'.$cat->getId().'/'.$info.'/" title="'.$cat->getTooltip($_SESSION['langue']).'" alt="'.$cat->getTooltip($_SESSION['langue']).'">'.$info.'</a></li>';
				}
				foreach ($cat->getChildCategories() as $tmpcat){
					$page.=$this->browseCategories($tmpcat);
				}
			}
		}
		return $page;
	}
}
?>