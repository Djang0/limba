<?php
/**
 * @package limba.interfaces
 * @author  Ludovic Reenaers
 * @since 30 nov. 2010
 * @link http://code.google.com/p/limba
*/

abstract class PropertyGenerator extends Generator{
	protected $Property;
	protected $CSS;
	function __construct($params,$factory,$Property){
		parent::__construct($params, $factory);
		$this->Property = $Property;
		if(!is_a($this->Property, "Document")){
			$this->CSS = "";
			if(!is_null($this->Property) && str_replace(' ','',$this->Property->getCssClass())<>""){
				$this->CSS .=' class="'.$this->Property->getCssClass().'"';
				
			}
			if(!is_null($this->Property) && str_replace(' ','',$this->Property->getCssId())<>""){
					$this->CSS .=' id="'.$this->Property->getCssId().'"';
			}
		}
	}
	abstract protected function getShow();
	abstract protected function getAddByIso($iso);
	abstract protected function getEditByIso($iso);
	protected function handleValidation(){
		
		if(!is_null($this->Property->getValidationMethod()) && trim($this->Property->getValidationMethod())<>'' && ($this->params["action"]=="add" || $this->params["action"]=="edit")){
			$methTab = array();
			foreach(explode(';',$this->Property->getValidationMethod()) as $method){
				if(!is_null($method) && trim($method)<>''){
					array_push($methTab,$method);
					FormManager::addValidationRule($this->Property->getId(),$methTab);		
				}
			}
		}
	}
	abstract protected function getAdmin();
	public function setUp(){
		$act= "get".ucfirst($this->params["action"]);
		$this->content=$this->$act();
	}
	
}
?>