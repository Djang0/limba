<?php
/**
 * @package limba.beans
 * @author   Ludovic Reenaers
 * @since 4 nov. 2009
 * @link  http://code.google.com/p/limba
 */
class Category{
	private $id;
	private $parentCatId;
	private $categories;
	private $documents;

	private $infos;
	private $is_root;
	private $owner_id;
	private $group_id;
	private $permission;
	
	private $visible;
	private $created;
	private $updated;
	private $alternate;
	private $position;
	
	function __construct($id) {
		Validator::validateId($id);
		$this->id=$id;
		$this->categories = array();
		$this->documents = array();
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
	public function setPosition($pos){
		$this->position = $pos;
	}
	public function getPosition(){
		return $this->position;
	}

	public function setAlternate($action){
		$this->alternate = $action;
	}
	public function getAlternate(){
		return $this->alternate;
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
	public function getInfos(){
		return $this->infos;
	}
	public function getTooltip($iso){
		$tooltip = "";
		foreach ($this->getInfos() as $Catinf){
			if(strtolower($Catinf->getLangue()->getIso()) == strtolower($iso)){
				$tooltip = $Catinf->getTooltip();
			}
		}
		return $tooltip;
	}
	public function getLabel($iso){
		$label = "";
		foreach ($this->getInfos() as $Catinf){

			if(strtolower($Catinf->getLangue()->getIso()) == strtolower($iso)){
				$label = $Catinf->getLabel();
			}
		}
		return $label;
	}
	public function setInfos($infoTab){
		if(is_array($infoTab)){
			$bool = true;
			foreach ($infoTab as $info){
				if  (!is_a($info, 'CategoryInfo')){
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
		}
	}
	public function getParentCategoryId(){
		return $this->parentCatId;
	}
	public function hasChildCategory($catid){
		$bool = false;
		if($catid == $this->getId()){

			$bool = true;
		}else{

			foreach ($this->getChildCategories() as $cat){
				if(!$bool){
					if($cat->getId() == $catid){
						$bool=true;
					}else{
						$bool = $cat->hasChildCategory($catid);
					}
				}
			}
		}
		return $bool;
	}
	public function containsDocument($docid){
		$bool = false;
		foreach ($this->getChildDocuments() as $doc){
			if($doc->getId() == $docid){
				$bool = true;
			}
		}
		return $bool;
	}
	public function hasChildDocument($docId){
		$bool = false;
		foreach ($this->getChildDocuments() as $tmpdoc){
			if(!$bool){
				if($tmpdoc->getId() == $docId){
					$bool=true;
				}
			}
		}
		if(!$bool){
			foreach ($this->getChildCategories() as $tmpcat){
				if(!$bool){
					$bool = $tmpcat->hasChildDocument($docId);
				}
			}
		}
		return $bool;
	}
	public function setChildCategories($catTab){
		if(is_array($catTab)){
			$bool = True;
			foreach ($catTab as $cat){
				if(!is_a($cat, 'Category')){
					$bool = False;
				}
			}
			if ($bool){
				$this->categories = $catTab;
			}else{
				trigger_error("ERR_BAD_LIST_FORMAT", E_USER_ERROR);
			}
		}else{
			trigger_error("ERR_NOT_AN_ARRAY", E_USER_ERROR);
		}
	}
	public function getChildCategories(){
		return $this->categories;
	}
	public function getChildCategory($catId){
		$categ = null;
		$bool = false;
		if($catId <> $this->id){
			foreach ($this->categories as $cat){
				if(!$bool){
					if($cat->id == $catId){
						$categ = $cat;
						$bool = true;
					}else{
						$categ = $cat->getChildCategory($catId);
						if(!is_null($categ)){
							$bool = true;
						}
					}
				}
			}
		}else{
			$categ = $this;
			$bool = true;
		}
		return $categ;
	}
	public function getDocument($docid){
		$thedoc = null;
		$bool = false;
		foreach ($this->documents as $doc){
			if (!$bool && $docid == $doc->getID()){
				$thedoc = $doc;
				$bool=true;
			}
		}
		if(!$bool){
			foreach ($this->categories as $cat){
				if(!$bool){
					$thedoc = $cat->getDocument($docid);
					if(!is_null($thedoc)){
						$bool = true;
					}
				}
			}
		}
		
		return $thedoc;
	}
	public function getChildDocument($id){
		$thedoc = null;
		foreach ($this->documents as $Doc){
		
				if($Doc->getId() == $id){
					$thedoc = $Doc;
			
				}
			
		}
		return $thedoc;
	}
	public function setChildDocuments($docTab){
		if(is_array($docTab)){
			$bool = True;
			foreach ($docTab as $doc){
				if(!is_a($doc, 'Document')){
					$bool = False;
				}
			}
			if ($bool){
				$this->documents = $docTab;
			}else{
				trigger_error("ERR_BAD_LIST_FORMAT", E_USER_ERROR);
			}
		}else{
			trigger_error("ERR_NOT_AN_ARRAY", E_USER_ERROR);
		}
	}
	public function getChildDocuments(){
		return $this->documents;
	}
	public function isRoot(){
		return $this->is_root;
	}
	public function setRootFlag($bool){
		if($bool==1 || $bool == 0){
			$this->is_root = $bool;
		}else{
			trigger_error("ERR_NOT_A_BOOLEAN", E_USER_ERROR);
		}
	}

}
?>