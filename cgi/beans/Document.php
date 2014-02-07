<?php
/**
 * @package limba.beans
 * @author   Ludovic Reenaers
 * @since 4 nov. 2009
 * @link  http://code.google.com/p/limba
 */
class Document{
	private $id;
	private $parentCatId;
	private $infos;
	private $TypeDocument;
	private $owner_id;
	private $group_id;
	private $permission;
	private $visible;
	private $created;
	private $updated;
	private $values;
	private $alternate;
	private $position;
	function __construct($id) {
		Validator::validateId($id);
		$this->id=$id;
	}
	public function setPosition($pos){
		$this->position = $pos;
	}
	public function getPosition(){
		return $this->position;
	}
	public function getAlternate(){
		return $this->alternate;
	}
	public function setAlternate($action){
		$this->alternate = $action;
	}

	public function setUpdated($stamp){
		$this->updated = $stamp;
	}
	public function getUpdated(){
		return $this->updated;
	}
	public function setCreated($stamp){
		$this->created = $stamp;
	}
	public function getCreated(){
		return $this->created;
	}
	public function isVisible(){
		return $this->visible;
	}
	public function setVisible($bool){
		if($bool==1 || $bool == 0){
			$this->visible = $bool;
		}else{
			trigger_error("ERR_NOT_A_BOOLEAN", E_USER_ERROR);
		}
	}
	function secureAddInfo($Info){
		$tmp = array();
		array_push($tmp, $Info);
		if(!is_null($this->infos)){
			foreach($this->infos as $I){
				if((int)$I->getLangue()->getId()<>(int)$Info->getLangue()->getId()){
					array_push($tmp, $I);		
				}
			}
		}
		$this->infos = $tmp;
	}
	public function setValues($valTab){
		$this->values = $valTab;
	}
	public function getValues(){
		return $this->values;
	}
	function setValue($valueid,$val){
		$theValObject = null;
		$meth = null;
		foreach ($this->values as $Val){
			if((int)$Val->getId() == (int)$valueid){
			
				$theValObject = $Val;
			}
		}
		$meth = "set".$this->seekMethodName((int)$theValObject->getPropertyId(),$this->TypeDocument->getProperties());
		if(!is_null($meth) && !is_null($theValObject)){
			$theValObject->$meth($val);
		}else{
			trigger_error("ERR_VALUE_METHOD", E_USER_ERROR);
		}
	}
	private function seekMethodName($propId,$proptab){
		$found=false;
		$meth = null;
		foreach($proptab as $Prop){
			if(is_null($meth) && !$found){
				if((int)$Prop->getId() == $propId ){
					$found=true;
					$meth = $Prop->getTypeProperty()->getMethod();
				}
				if(!$found && $Prop->hasChild()){
					$meth = $this->seekMethodName($propId,$Prop->getChildren());
				}
			}
		}
		return $meth;
	}
	function buildValueForPropertyId($propId,$value,$Langue){
		$Val = null;
		$Prop = $this->TypeDocument->getProperty($propId);
		
		$meth = "set".$Prop->getTypeProperty()->getMethod();
		
		$Val = new PropertyValue(0);
		$Val->$meth($value);
		$Val->setLangue($Langue);
		//$Val->setDocumentId();
		$Val->setPropertyId((int)$propId);
		return $Val;	
	}
	function setMeta($metaname,$metaiso,$val){
		
		foreach ($this->getInfos() as $Info){
			if($Info->getLangue()->getIso()==$metaiso){
				if($metaname=="label"){
					$Info->setLabel($val);
				}elseif ($metaname=="tooltip"){
					$Info->setTooltip($val);
				}
			}
		}
	}
	function setPermission($permStr){
		$bool=true;
		for ($i=0;$i<strlen($permStr);$i++){
			if($permStr[$i]<>'1' && $permStr[$i]<>'0'){
				$bool = false;
			}
		}
		if($bool){
			$this->permission=$permStr;
		}else{
			trigger_error("ERR_BAD_PERMISSION_FORMAT", E_USER_ERROR);
		}
	}
	function setOwnerId($id) {

		if (is_int($id)){
			if($id >= 0){
				$this->owner_id=$id;
			}else{
				trigger_error("ERR_WRONG_VALUE", E_USER_ERROR);
			}
		}else{
			trigger_error("ERR_NOT_AN_INTEGER", E_USER_ERROR);
		}
	}
	function setGroupId($id) {

		if (is_int($id)){
			if($id >= 0){
				$this->group_id=$id;
			}else{
				trigger_error("ERR_WRONG_VALUE", E_USER_ERROR);
			}
		}else{
			trigger_error("ERR_NOT_AN_INTEGER", E_USER_ERROR);
		}
	}
	function getOwnerId(){
		return $this->owner_id;
	}
	function getGroupId(){
		return $this->group_id;
	}
	function getPermission(){
		return $this->permission;
	}
	public function getId(){
		return $this->id;
	}
	public function getProperties(){
		
		return $this->TypeDocument->getProperties();
	}
	public function getProperty($TypeProperty){
		return $this->TypeDocument->getPropertyValue($TypeProperty,$this->getId());
	}
	public function setProperties($propTab){
		$this->TypeDocument->setProperties($propTab);
	}
	public function setTypeDocument($TypeDocument){
		if(is_a($TypeDocument, 'TypeDocument')){
			$this->TypeDocument = $TypeDocument;
		}
		else{
			trigger_error("ERR_WRONG_KIND_OF_INSTANCE", E_USER_ERROR);
		}
	}
	public function getTypeDocument(){
		return $this->TypeDocument;
	}
	public function getTooltip($iso){
		$tooltip = "";
		if(!is_null($this->getInfos())){
			foreach ($this->getInfos() as $Docinf){
				if(strtolower($Docinf->getLangue()->getIso()) == strtolower($iso)){
					$tooltip = $Docinf->getTooltip();
				}
			}
		}
		return $tooltip;
	}
	public function getLabel($iso){
		$label = "";
		if (!is_null($this->getInfos())){
			foreach ($this->getInfos() as $Docinf){
	
				if(strtolower($Docinf->getLangue()->getIso()) == strtolower($iso)){
					$label = $Docinf->getLabel();
				}
			}
		}
		return $label;
	}

	public function getInfos(){
		return $this->infos;
	}
	public function getInfo($Langue){
		$Inf = null;
		if(!is_null($this->infos)){
			foreach($this->infos as $Info){
				if($Info->getLangue()->getIso() == $Langue->getIso()){
					$Inf = $Info;
				}
			}
		}
		return $Inf;
	}
	public function setInfos($infoTab){
		if(is_array($infoTab)){
			$bool = true;
			foreach ($infoTab as $info){
				if  (!is_a($info, 'DocumentInfo')){
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
	
	public function setParentCategoryId($parentCatId){
		if (is_int($parentCatId)){
			$this->parentCatId = $parentCatId;
		}else{
			trigger_error("ERR_NOT_AN_INTEGER", E_USER_ERROR);
		}
	}
	public function getParentCategoryId(){
		return $this->parentCatId;
	}
	public function addValue($ValObj){
		array_push($this->values,$ValObj);
	}
	public function convertPostToPropertyValue($TabParam,$Langue,$val){
		$Val = null;
		
		if ($TabParam[0] == "{str}"){
			
			$Val = $this->buildValueForPropertyId($TabParam[1],$val,$Langue);
		}elseif ($TabParam[0] == "{xpe}"){
			$bool = isset($_POST["{chk}_".$tab[1]."_".$TabParam[2]]);
			$Val = $this->buildValueForPropertyId($TabParam[1],$bool,$Langue);
		}elseif ($TabParam[0] == "{dfr}"){
			$interv = array();
			array_push($interv, $val, $_POST["{dto}_".$TabParam[1]."_".$TabParam[2]]);
			$Val = $this->buildValueForPropertyId($TabParam[1],$interv,$Langue);
		}
		
		return $Val;
	}
}
?>