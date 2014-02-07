<?php
/**
 * @package limba.generators.public.components.navigation
 * @author  Ludovic Reenaers
 * @since 21 janv. 2009
 * @link http://code.google.com/p/limba
 */

class BreadCrumbGenerator extends Generator{
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
		
		if( $this->params["module"]<>"language"){
			$this->content = '<ul class="crumbs"><li><a href="'.$_SERVER['SCRIPT_NAME'].'?/homepage/show/">'.$this->params['translator']->home.'</a></li>';
			if ($this->params["module"]=="document" || $this->params["module"]=="category"){
				$this->content.=$this->browseCategories($this->params['rootCat']);
				if ($this->params["module"]=="document"){
					$this->content.='<li class="current">'.$this->params["title"]."b</li>";
				}
			}elseif($this->params["module"]=="homepage"){
				$this->content.='';
			}else{
				$this->content.='<li class="current">'.$this->params["title"]."</li>";
			}
			$this->content .= '</ul>';
		}else{
			$this->content = '<ul class="crumbs"><li></li></ul>';
		}
	}
	private function browseCategories($cat){
		$page='';
		if($this->params["module"]=="category"){
			if($cat->hasChildCategory((int)$this->params["currentid"])){
				array_push($this->catPath, $cat->getId());
				if(!$cat->isRoot()){
					$info = $cat->getLabel($_SESSION['langue']);
					 if(!is_null($cat->getAlternate()) && trim($cat->getAlternate())<>''){
                     	$url = $_SERVER['SCRIPT_NAME'].'?'.$cat->getAlternate();
                     }elseif($cat->getId()==(int)$this->params['config']->HomepageId || $cat->getId()==(int)$this->params['config']->HomepageCatId ){
                     	$url = $_SERVER['SCRIPT_NAME'].'?/homepage/show/';
                     }else{
                        $url = $_SERVER['SCRIPT_NAME'].'?/category/show/'.$cat->getId().'/'.$info.'/';
                     }						
					if((int)$this->params["currentid"]== $cat->getId() && ((int)$cat->getId() <> (int)$this->params['config']->HomepageCatId)){
						$page.= '<li class="current">'.$info."</li>";
					}elseif((int)$cat->getId() == (int)$this->params['config']->HomepageCatId){
						$page.='';
					}else{
						$page.= '<li><a href="'.$url.'" title="'.$cat->getTooltip($_SESSION['langue']).'" alt="'.$cat->getTooltip($_SESSION['langue']).'">'.$info.'</a></li>';
					}	
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
					if(!is_null($cat->getAlternate()) && trim($cat->getAlternate())<>''){
                     	$url = $_SERVER['SCRIPT_NAME'].'?'.$cat->getAlternate();
                     }elseif($cat->getId()==(int)$this->params['config']->HomepageId || $cat->getId()==(int)$this->params['config']->HomepageCatId ){
                     	$url = $_SERVER['SCRIPT_NAME'].'?/homepage/show/';
                     }else{
                        $url = $_SERVER['SCRIPT_NAME'].'?/category/show/'.$cat->getId().'/'.$info.'/';
                     }
					$page.= '<li><a href="'.$url.'" title="'.$cat->getTooltip($_SESSION['langue']).'" alt="'.$cat->getTooltip($_SESSION['langue']).'">'.$info.'</a></li>';
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