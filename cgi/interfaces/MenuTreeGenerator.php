<?php
/**
 * @package limba.interfaces
 * @author  Ludovic Reenaers
 * @since 19 mars 2011
 * @link http://code.google.com/p/limba
 */
abstract class MenuTreeGenerator extends Generator{
	protected $lvl;
	protected $rootCat;
	protected $SM;
	protected  $maxRecurse;
	function __construct($params, $factory){
		parent::__construct($params, $factory);
		$this->setRootCategory($this->params['rootCat']);
		$this->setSecurityManager($this->params['SM']);
		$this->lvl = 0;
		$this->maxRecurse = $this->params['maxRecurse'];
	}
 	protected function setRootCategory($RootCategory){
		$this->rootCat = $RootCategory;
	}
 	protected function authorizeTreeItem($Bean){
		return $this->SM->authorizeAccessToObject($Bean,"R");
	}
 	protected function setSecurityManager($SM){
		$this->SM = $SM;
	}
 	function setUp(){
		$this->lvl = 0;
		$this->maxRecurse = 3;
		
		$this->content = $this->dumpCategories();
		
	}
	protected function dumpCategories(){
		$category = $this->rootCat->getChildCategory($this->params['menuCatId']);
		$strr=null;
		$strr = $this->dumpCategory($category);
		return $strr;
	}
	
	abstract protected function dumpCategory($category);
}
?>