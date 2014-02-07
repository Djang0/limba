<?php
/**
 * @package limba.beans
 * @author   Ludovic Reenaers
 * @since 24 nov. 2010
 * @link  http://code.google.com/p/limba
 */
class TypeDocument{
	private $id;
	private $label;
	private $available;
	private $Properties;
	function __construct($id) {
		Validator::validateId($id);
		$this->id=$id;
	}
	public function setProperties($PropTab){
		
		if(is_array($PropTab)){
			$bool = true;
			foreach ($PropTab as $Prop){
				if  (!is_a($Prop, 'Property')){
					$bool=false;
				}
			}
			if (!$bool){
				trigger_error("ERR_BAD_LIST_FORMAT", E_USER_ERROR);
			}else{
				$this->Properties=$PropTab;
			}
		}else{
			trigger_error("ERR_NOT_AN_ARRAY", E_USER_ERROR);
		}
	}
	public function getProperties(){
		return $this->Properties;
	}
	public function getPropertyValue($TypeProp,$DocId){
		$val = null;
		foreach ($this->getProperties() as $prop){
			if(is_null($val)){
				$val=$prop->getValueByType($TypeProp);
			}
		}
		return $val;
	}
	function getProperty($propid){
		return $this->findProperty($this->Properties,$propid);
	}
	private function findProperty($propTab,$propId){
		$pro = null;
		foreach ($propTab as $Prop){
			if($Prop->getId() == $propId){
				$pro = $Prop;
			}
			if (is_null($pro)){
				$pro = $this->findProperty($Prop->getChildren(),$propId);	
			}
		}
		return $pro;
	}
	public function getId(){
		return $this->id;
	}
	public function setLabel($labelstr){
		$this->label = $labelstr;
	}
	public function getLabel(){
		return $this->label;
	}
	public function setAvailable($bool){

		$this->available = $bool;

	}
	public function isAvailable(){
		return $this->available;
	}


}
?>