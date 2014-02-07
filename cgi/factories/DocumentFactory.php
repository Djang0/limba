<?php
/**
 * @package limba.factories
 * @author  Ludovic Reenaers
 * @since 24 nov. 2010
 * @link http://code.google.com/p/limba
 */

class DocumentFactory{
	private $Document;
	private $params;
	private $Factory;
	private $mode;
	function __construct($params,$factory,$mode='ADM') {
		$this->mode= $mode;
		if(is_a($factory, 'DAOFactory')){
			$this->Factory = $factory;
		}else{

			trigger_error("ERR_BAD_DAO_FACTORY", E_USER_ERROR);
		}
		$this->params = $params;
		$dao=$this->Factory->getDocumentDAO();
		if($this->params["currentid"]==0){
			$this->Document = new Document(0);
			$typeDAO = $this->Factory->getTypeDocumentDAO();
			if(isset($this->params["typeid"]) && trim($this->params["typeid"])<>''){
				$type= $typeDAO->getById((int)$this->params["typeid"]);
			}else{
				$type= $typeDAO->getByLabel($this->params["typelabel"]);
			}
			$this->Document->setTypeDocument($type); 
		}else{
			
			$this->Document = $dao->getById((int)$this->params["currentid"]);
		}
	}
	private function dumpProperty($Prop){
		
		$propGenName = ucfirst($Prop->getTypeProperty()->getLabel())."Generator";
		$propGen = null;
		$propGen = new $propGenName($this->params,$this->Factory,$Prop);
		
		if ($Prop->hasChild()){
			
			foreach ($Prop->getChildren() as $child){
				
				$propGen->addChild($this->dumpProperty($child));
				
			}
		}
		return $propGen;
	}
	function dump(){
		
		$str = "";
		$mainGen = new DocumentGenerator($this->params,$this->Factory,$this->Document,$this->mode);
		
		foreach ($this->Document->getProperties() as $Prop){
			$mainGen->addChild($this->dumpProperty($Prop));
		}
		$str= $mainGen->dump();
		return $str;
	}
}
?>