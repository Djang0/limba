<?php
/**
 * @package limba.models
 * @author  Ludovic Reenaers
 * @since 23 sept. 2010
 * @link http://code.google.com/p/limba
 */

class ModelDocument extends Model{
	function show(){
		$factory  = new DocumentFactory($this->params,$this->factory);
		return $factory;
	}
	function admin(){
		$factory  = new DocumentFactory($this->params,$this->factory);
		return $factory;
	}
	function edit(){
		FormManager::setUrls($_SERVER['SCRIPT_NAME']."?/document/admin/".$this->params["currentid"]."/".$this->params["title"]."/",$_SERVER['SCRIPT_NAME']."?/document/admin/".$this->params["currentid"]."/".$this->params["title"]."/");
		$factory  = new DocumentFactory($this->params,$this->factory);
		return $factory;
	}
	function add(){
		FormManager::setUrls($_SERVER['SCRIPT_NAME']."?/category/admin/".$this->params["targetcatid"]."/",$_SERVER['SCRIPT_NAME']."?/category/admin/".$this->params["targetcatid"]."/");
		$factory  = new DocumentFactory($this->params,$this->factory);
		return $factory;
		
	}
	
	function insert(){
		$DAO = $this->factory->getDocumentDAO();
		$typeDocDAO = $this->factory->getTypeDocumentDAO();
		$propDAO = $this->factory->getPropertyDAO();
		$catDAO =  $this->factory->getCategoryDAO();
		$langDAO = $this->factory->getLangueDAO();
		$docInfoDAO = $this->factory->getDocumentInfoDAO();
		$valDAO = $this->factory->getPropertyValueDAO();
		$Cat = $catDAO->getById((int)$_POST['targetcatid']);
		$Document = new Document(0);
		$Document->setOwnerId((int)$_SESSION['USER_BEAN']->getId());
		$Document->setGroupId($Cat->getGroupId());
		$Document->setPermission($Cat->getPermission());
		$Document->setParentCategoryId((int)$_POST['targetcatid']);
		$typeDoc = $typeDocDAO->getById((int)$_POST['typedocid']);
		$Document->setTypeDocument($typeDoc);
		$infos = array();
		$values = array();
		foreach($_POST as $key=>$val){
			$tab = explode("_",$key);
			if (isset($tab[2])){
				$Langue = $langDAO->getByIso($tab[2]);
				if($tab[0] == "{meta}"){
					
					$Info = $Document->getInfo($Langue);
					if(is_null($Info)){
						$Info = new DocumentInfo(0);
						$Info->setDocumentId($Document->getId());
						$Info->setLangue($Langue);
					}
					$meth = "set".ucfirst($tab[1]);
					$Info->$meth($val);
					$Document->secureAddInfo($Info);
				}else{
					$Val = $Document->convertPostToPropertyValue($tab,$Langue,$val);
					if(!is_null($Val)){	
						FormManager::validateProperty((int)$tab[1],$val);
						array_push($values,$Val);
					}
				}
			}
		}
		$Document->setValues($values);
		$Document = $DAO->add($Document);
		return "";
	}
	

	function update(){
		$docid = $_POST["currentid"];
		$DAO = $this->factory->getDocumentDAO();
		$langDAO = $this->factory->getLangueDAO();
		$Document = $DAO->getById((int)$docid);
		foreach($_POST as $key=>$val){
			$tab = explode("_",$key);
			if(count($tab)>1){
				if($tab[0] == "{meta}"){
					$Document->setMeta($tab[1],$tab[2],$val);
				}else{
					if($tab[1]=='{ins}'){
						$tmptab = array();
						$cp=0;
						$Langue = $langDAO->getByIso($tab[3]);
						foreach($tab as $k=>$v){
							if($k<>1){
								$tmptab[$cp] = $v;
								$cp++;
							}
						}
						$Val = $Document->convertPostToPropertyValue($tmptab,$Langue,$val);
						if(!is_null($Val)){	
							FormManager::validateProperty((int)$tab[2],$val);
							$Document->addValue($Val);
						}
					}else{
						$valueid = (int)$tab[1];
						if ($tab[0] == "{str}"){
							$value = $val;
						}elseif ($tab[0] == "{dfr}"){
							$value = array();
							array_push($value, $val, $_POST["{dto}_".$valueid]);
						}elseif ($tab[0] == "{xpe}"){
							$value = isset($_POST["{chk}_".$valueid]);
						}
						FormManager::validateProperty($valueid,$val);
						$Document->setValue($valueid,$value);
					}
				}
			}
		}
		$DAO->update($Document);
		
		return "";
	}
}
?>