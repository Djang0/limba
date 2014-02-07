<?php
/**
 * @package limba.beans
 * @author   Ludovic Reenaers
 * @since 4 nov. 2010
 * @link  http://code.google.com/p/limba
 */
class Property{
	private $id;
	private $infos;
	private $is_default;
	private $TypeProperty;
	private $Liste;
	private $TypeDocumentid;
	private $childProperties;
	private $parentId;
	private $cssId;
	private $cssClass;
	private $validation_method;
	private $nable;
	function __construct($id) {
		Validator::validateId($id);
		$this->id=$id;
	}
	public function setValidationMethod($methodestr){
		$this->validation_method = $methodestr;
	}
	public function getValidationMethod(){
		return $this->validation_method;
	}
	public function setCssClass($classStr){
		$this->cssClass=$classStr;
	}
	public function setCssId($cssId){
		$this->cssId = $cssId;
	}
	public function getCssClass(){
		return $this->cssClass;
	}
	public function getCssId(){
		return $this->cssId;
	}
	function hasChild(){
		$bool = false;
		if(count($this->childProperties)>0){
			$bool=true;
		}
		return $bool;
	}
	function setParentId($id) {

		if (is_int($id)){
			if($id >= 0){
				$this->parentId=$id;
			}else{
				trigger_error("ERR_WRONG_VALUE", E_USER_ERROR);
			}
		}else{
			trigger_error("ERR_NOT_AN_INTEGER", E_USER_ERROR);
		}
	}
	function getParentId(){
		return $this->parentId;
	}
	public function setChildren($PropTab){
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
				$this->childProperties=$PropTab;
			}
		}else{
			trigger_error("ERR_NOT_AN_ARRAY", E_USER_ERROR);
		}
	}
	public function getChildren(){
		return $this->childProperties;
	}
	public function setTypeDocumentId($id){
		if (is_int($id)){
			if($id >= 0){
				$this->TypeDocumentid=$id;
			}else{
				trigger_error("ERR_WRONG_VALUE", E_USER_ERROR);
			}
		}else{
			trigger_error("ERR_NOT_AN_INTEGER", E_USER_ERROR);
		}
	}
	public function getTypeDocumentId(){
		return $this->TypeDocumentid;
	}
	public function getId(){
		return $this->id;
	}
	public function getInfos(){
		return $this->infos;
	}
	public function getInfo($iso){
		$val =null;
		foreach ($this->infos as $Info){
			
			if($Info->getLangue()->getIso()==$iso){
				$val = $Info->getLabel();
			}
		}
		return $val;
	}
	public function getTooltip($iso){
		$val =null;
		foreach ($this->infos as $Info){
			
			if($Info->getLangue()->getIso()==$iso){
				$val = $Info->getTooltip();
			}
		}
		return $val;
	}
	public function isDefault(){
		return $this->is_default;
	}
	public function isNable(){
		return $this->nable;
	}
	public function getTypeProperty(){
		return $this->TypeProperty;
	}
	public function getListe(){
		return $this->Liste;
	}
	public function setDefault($bool){
		if($bool==1 || $bool == 0){
			$this->is_default = $bool;
		}else{
			trigger_error("ERR_NOT_A_BOOLEAN", E_USER_ERROR);
		}
	}
	public function setNable($bool){
		if($bool==1 || $bool == 0){
			$this->nable = $bool;
		}else{
			trigger_error("ERR_NOT_A_BOOLEAN", E_USER_ERROR);
		}
	}
	public function setTypeProperty($TypeProperty){
		if(is_a($TypeProperty, 'TypeProperty')){
			$this->TypeProperty = $TypeProperty;
		}else{
			trigger_error("ERR_WRONG_KIND_OF_INSTANCE", E_USER_ERROR);
		}
	}
	public function setListe($Liste){
		if(is_a($Liste, 'Liste')){
			$this->Liste = $Liste;
		}
	}
	public function setInfos($infoTab){
		if(is_array($infoTab)){
			$bool = true;
			foreach ($infoTab as $info){
				if  (!is_a($info, 'PropertyInfo')){
					$bool=false;
				}
			}
			if (!$bool){
				trigger_error("ERR_BAD_LIST_FORMAT", E_USER_ERROR);
			}else{
				$this->infos=$infoTab;
			}
		}else{
			trigger_error("ERR_NOT_AN_ARRAY", E_USER_ERROR);
		}
	}
}