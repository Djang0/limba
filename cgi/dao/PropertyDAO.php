<?php
/**
 * @package limba.dao
 * @author  Ludovic Reenaers
 * @since 4 nov. 2010
 * 
 * @link http://code.google.com/p/limba
 */
class PropertyDAO extends DAO{

	function getById($id){
		try
		{
			$id = StringHelper::escapeSql($id);
			$query="select * from PROPERTY where id=$id;";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$propInfoDAO = $this->factory->getPropertyInfoDAO();
			$typePropDAO = $this->factory->getTypePropertyDAO();
			$TypeDocDAO = $this->factory->getTypeDocumentDAO();
			$propValueDAO = $this->factory->getPropertyValueDAO();
			$ListDAO = $this->factory->getListeDAO();
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = new Property((int)$Bean->ID);				
				$thebean->setDefault($Bean->IS_DEFAULT);				
				$thebean->setTypeProperty($typePropDAO->getById((int)$Bean->TYPE_PROPERTY_ID));				
				$thebean->setListe($ListDAO->getById((int)$Bean->LIST_ID));				
				$thebean->setInfos($propInfoDAO->getAllByProperty($thebean));				
				$thebean->setTypeDocumentId((int)$Bean->TYPE_DOCUMENT);		
				$thebean->setChildren($this->getByParent((int)$Bean->ID));
				$thebean->setParentId((int)$Bean->PARENT_PROP);
				$thebean->setCssClass($Bean->CSS_CLASS);
				$thebean->setCssId($Bean->CSS_ID);
				$thebean->setValidationMethod($Bean->VALIDATION_METHOD);
				$thebean->setNable($Bean->NABLE);
				$thebean->setChildren($this->getByProperty($thebean));
			}
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $thebean;
	}
	function getByProperty($bean){
		try
		{
			$BeanArray = array();
			$query="select * from PROPERTY where PARENT_PROP=".StringHelper::escapeSql($bean->getId())." order by ID asc;";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = $this->getById((int)$Bean->ID);	
				array_push($BeanArray,$thebean);			
			}
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $BeanArray;
	}

//	function remove($Bean){
//		try{
//			$propInfoDAO = $this->factory->getPropertyInfoDAO();
//			foreach ($Bean->getInfos() as $Info){
//				$propInfoDAO->remove($Info);$thebean->setValues($propValueDAO->getAllByPropertyByDocument($bean,$thebean));
//			}
//			foreach ($Bean->getChildren() as $Child){
//				$this->remove($Child);
//			}
//			$query="delete from PROPERTY where id='".StringHelper::escapeSql($Bean->getId())."';";
//			$this->pdo->exec($query);
//			$bool=true;
//		}catch(Exception $e)    {
//			$bool=false;
//		}
//		return $bool;
//
//	}
	function update($Bean){
		try{
			$propInfoDAO = $this->factory->getPropertyInfoDAO();
//			$propValueDAO = $this->factory->getPropertyValueDAO();
//			foreach ($Bean->getValues() as $Value){
//				if($Value->getId()>0){
//					$propValueDAO->update($Value);
//				}else{
//					$propValueDAO->add($Value);
//				}
//			}
			foreach ($Bean->getInfos() as $Info){
				$propInfoDAO->update($Info);
			}
			foreach ($Bean->getChildren() as $Child){
				$this->update($Child);
			}
			$query = "update PROPERTY set is_default=".StringHelper::escapeSql($Bean->isDefault()).",";
			$query.="type_property_id=".StringHelper::escapeSql($Bean->getTypeProperty()->getId()).",";
			$query.="TYPE_DOCUMENT=".StringHelper::escapeSql($Bean->getTypeDocumentId()).",";
			$ls=$Bean->getListe();
			if(!is_null($ls)){
				$query.="list_id=".StringHelper::escapeSql($ls->getId()).",";
			}
			if(!is_null($Bean->getParentId()) and (int)$Bean->getParentId()>0){
				$query.=" PARENT_PROP=".StringHelper::escapeSql($Bean->getParentId()).",";
			}
			$query.=" CSS_CLASS='".StringHelper::escapeSql($Bean->getCssClass())."',";
			$query.=" VALIDATION_METHOD='".StringHelper::escapeSql($Bean->getValidationMethod())."',";
			$query.="CSS_ID='".StringHelper::escapeSql($Bean->getCssId())."'";
			$query.=" where id=".StringHelper::escapeSql($Bean->getId()).";";
			$this->pdo->exec($query);
			$bool=true;
		}
		catch(Exception $e)     {
			$bool=false;

		}
		return $bool;
	}
	function add($Bean){
		 
		try{
			 
			if (is_null($Bean->getId())){
				$propInfoDAO = $this->factory->getPropertyInfoDAO();
				//$valDAO = $this->factory->getPropertyValueDAO();
				foreach ($Bean->getInfos() as $Info){
					$propInfoDAO->add($Info);
				}
//				foreach ($Bean->getValues() as $Val){
//					$valDAO->add($Val);
//				}
				foreach ($Bean->getChildren() as $Child){
					$propInfoDAO->add($Child);
				}
				$thebean = null;
				$insertQuery = "insert into PROPERTY (is_default,type_property_id,TYPE_DOCUMENT,list_id,PARENT_PROP,CSS_CLASS,CSS_ID,VALIDATION_METHO) values (".StringHelper::escapeSql($Bean->isDefault()).",".StringHelper::escapeSql($Bean->getTypeProperty()->getId()).",".StringHelper::escapeSql($Bean->getTypeDocument()->getId()).",".StringHelper::escapeSql($Bean->getListe()->getId()).",".StringHelper::escapeSql($Bean->getParentId()).",'".StringHelper::escapeSql($Bean->getCssClass())."','".StringHelper::escapeSql($Bean->getCssId())."','".StringHelper::escapeSql($Bean->getValidationMethod())."');";
				$this->pdo->exec($insertQuery);
				$thebean = $this->getById((int)$this->pdo->lastInsertId());
			}
		}catch(Exception $e)    {$this->pdo->message;}
		return $thebean;
	}

	function All(){
		try
		{

			$BeanArray = array();
			$query="select * from PROPERTY order by id asc;";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = $this->getById((int)$Bean->ID);
				array_push($BeanArray,$thebean);
			}
				
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $BeanArray;

	}
	
	function getByParent($id){
		try
		{

			$BeanArray = array();
			$query="select * from PROPERTY where PARENT_PROP=".StringHelper::escapeSql($id)." order by id asc;";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$propValueDAO = $this->factory->getPropertyValueDAO();
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = $this->getById((int)$Bean->ID);
				array_push($BeanArray,$thebean);
			}
				
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $BeanArray;
	}
	public function getByTypeDocument($bean){
		try
		{

			$BeanArray = array();
			$query="select * from PROPERTY where TYPE_DOCUMENT=".StringHelper::escapeSql($bean->getId())." and PARENT_PROP IS NULL order by ID asc;";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$propValueDAO = $this->factory->getPropertyValueDAO();
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = $this->getById((int)$Bean->ID);
				array_push($BeanArray,$thebean);
			}
				
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $BeanArray;
	}
//	public function getByDocument($docBean,$typeDocId){
//		try
//		{
//			$this->currentDoc = $docBean;
//			$BeanArray = array();
//			$query="select * from PROPERTY where TYPE_DOCUMENT=".StringHelper::escapeSql($typeDocId)." and PARENT_PROP IS NULL order by ID asc;";
//			$statement=$this->pdo->query($query);
//			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
//			
//			$thebean = null;
//			foreach($array_obj as $Bean){
//				$thebean = $this->getById((int)$Bean->ID);
//				
//				array_push($BeanArray,$thebean);
//			}
//				
//		}
//		catch(Exception $e)     {
//			throw $e;
//		}
//
//		return $BeanArray;
//	}
}
?>