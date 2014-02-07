<?php
/**
 * @package limba.interfaces
 * @since 21 janv. 2009
 * @author  Ludovic Reenaers
 * @link http://code.google.com/p/limba
 */
class Model
{
	protected $params;
	protected $factory;
	protected $replacements;
	protected $template;
	
	function __construct($params)
	{
		$this->params = $params;
		$this->factory = new DAOFactory($this->params);
		if(get_class($this)<>"Model"){
			$this->setLanguage();
			$this->params['translator'] = new DBTranslator($this->factory);
			if($_SERVER["SCRIPT_NAME"] == "/index.php"){
				$this->params["menuCatId"]= (int)$this->params['config']->publicCatId;
				//$rootCatId= (int)$this->params['config']->rootCatId;
			}else{
				$this->params["menuCatId"]= (int)$this->params['config']->rootCatId;
			}
			$this->params["rootCat"] = $this->factory->getCategoryDAO()->getById((int)$this->params['config']->rootCatId);
			$this->setTitle($this->params['rootCat']);
			$this->params["currentAccess"] = $this->getCurrentAccess();
			if(is_null($this->params["currentAccess"])&&($this->params['module']=='document' || $this->params['module']=='category')){
				trigger_error("ERR_PAGE_NOT_FOUND", E_USER_ERROR);
			}
			
			$this->params['SM'] = new SecurityManager($this->params); 
			if($this->params['SM']->getStatus()){
				$this->setReplacements();
			}
		}
	}
	function getData(){
		if(!is_null($this->replacements)){
			foreach ($this->replacements as $key=>$value){
				$this->template = str_replace($key, $value, $this->template);
			}
		}
		return $this->template;
	}
	private function setTitle($rootCat){
		if(strtolower($this->params["module"])=="category"){
			$title = $rootCat->getChildCategory($this->params['currentid'])->getLabel($_SESSION['langue']);
			//$title = $rootCat->getLabel($_SESSION['langue']);
		}elseif (strtolower($this->params["module"])=="document"){
			if($this->params['action'] <>'add' && $this->params['action'] <>'insert' && $this->params['action'] <>'update'){
				$doc = $rootCat->getDocument((int)$this->params["currentid"]);
				
				$title = $doc->getLabel($_SESSION['langue']);
			}else{
				$title= $this->params['translator']->addDoc;
			}
			
		}elseif ($this->params["module"] == "user" && $this->params["action"] == "edit"){
			$title = $this->params['translator']->prefs;
			
		}elseif ($this->params["module"] == "user" && $this->params["action"] == "add"){
			$title = $this->params['translator']->register;
			
		}elseif ($this->params["module"] == "login" && $this->params["action"] == "show"){
			
			$title = $this->params['translator']->login;
		}elseif ($this->params["module"] == "login" && $this->params["action"] == "forgot"){
			
			$title = $this->params['translator']->forgotpws;
		}elseif ($this->params["module"] == "homepage"){
			$title = $this->params['translator']->home;
		}else{
			$title = ucfirst($this->params['module']).' '.ucfirst($this->params['action']);
		}
		$this->params['title']=$title;
	}	
	private function setReplacements(){
		
		foreach ($this->params['config']->layout as $layout){
			if ("/".(string)$layout['name'].".php" == $_SERVER["SCRIPT_NAME"]){
				$this->template = file_get_contents((string)$layout->basetemplate);
				$this->params['maxRecurse'] = (int)$layout->maxRecurse;
				foreach ($layout->generators->FileContentGenerator as $filegen){
					$gen = new FileContentGenerator($this->params, $this->factory, (string)$filegen->file);
					$this->replacements[(string)$filegen->substitutiontag]=$gen->dump();
				}
				foreach ($layout->generators->ClassGenerator as $clsgen){
					$genstr = (string) $clsgen->classname;
					$gen = new $genstr($this->params, $this->factory);
					$this->replacements[(string)$clsgen->substitutiontag]=$gen->dump();
					$this->params = $gen->getParams();
				}
			}
		}
	}
	private function getCurrentAccess(){
		$DAO = null;
		$access = null;
	
		if(($this->params["module"]=="category" || $this->params["action"]=="add"|| $this->params["action"]=="insert") && ($this->params["module"]<>"user")){
	
			$DAO = $this->factory->getCategoryDAO();
		}elseif($this->params["module"]=="document"){
	
			$DAO=$this->factory->getDocumentDAO();
		}
		if(!is_null($DAO)){
	
			if($this->params["action"]=="add" && ($this->params["module"]=="category" || $this->params["module"]=="document")){
	
				$access = $DAO->getSummaryById($this->params["targetcatid"]);;
			}else{
	
				$access = $DAO->getSummaryById($this->params["currentid"]);
			}
		}
		return $access;
	}
	private function setLanguage(){
			$ckVal = $this->getLanguageIsoCookyValue();
			if($_SESSION["USER_BEAN"]->getName()=="anonymous"){
				if(is_null($ckVal)){
						
					$_SESSION['langue'] = $this->getDefaultLanguageIso();
						
				}else{
						
					$_SESSION['langue'] = $ckVal;
				}
			}else{
				$_SESSION['langue'] = $_SESSION['USER_BEAN']->getLAngue()->getIso();
			}
	}
	public function getFactory(){
		return $this->factory;
	}
	public function getCurrentId(){
		return $this->params["currentid"];
	}
	public function getTitle(){
		return $this->params["title"];
	}

	function getLanguageIsoCookyValue(){
			
		if (!isset($_COOKIE[(string)$this->params['config']->sitename]['langue'])||is_null($_COOKIE[(string)$this->params['config']->sitename]['langue']) || $_COOKIE[(string)$this->params['config']->sitename]['langue'] == ''){
			$tmp = null;
		}else{
			$tmp = $_COOKIE[(string)$this->params['config']->sitename]['langue'];
		}
		return $tmp;
	}
	function getDefaultLanguageIso(){
		$lngDAO = $this->factory->getLangueDAO();
		$lng = $lngDAO->getDefaultLanguage();
		return $lng->getIso();
	}

	function getAnonymousUser(){
		
		return $this->factory->getUserDAO()->getAnonymousUser();
		
	}

	function getLangues(){
		return $this->factory->getLangueDAO()->all();
	}
	
	function updateUserSecInfo(){
		$usrDAO = $this->factory->getUserDAO();
		$usrDAO->updateSecInfo($_SESSION['USER_BEAN']);
	}

}
?>