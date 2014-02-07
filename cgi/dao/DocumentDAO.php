<?php
/**
 * @package limba.dao
 * @author  Ludovic Reenaers
 * @since 24 janv. 2009
 * 
 * @link http://code.google.com/p/limba
 */
class DocumentDAO extends DAO{


	public function getById($id){
		try
		{
			$id =StringHelper::escapeSql($id);
			$query="select * from DOCUMENTS where id=$id;";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$docInfoDAO = $this->factory->getDocumentInfoDAO();
			$typDocDAO = $this->factory->getTypeDocumentDAO();
			$propValDAO = $this->factory->getPropertyValueDAO();
			$thebean = null;
			foreach($array_obj as $Bean){
				
				$thebean = new Document((int)$Bean->ID);
				$thebean->setParentCategoryId((int)$Bean->PARENT_CAT_ID);
				$thebean->setGroupId((int)$Bean->GROUP_ID);
				$thebean->setOwnerId((int)$Bean->OWNER_ID);
				$thebean->setPermission($Bean->PERM_BIN);
				$thebean->setCreated($Bean->CREATED);
				$thebean->setUpdated($Bean->UPDATED);
				$thebean->setVisible($Bean->VISIBLE);
				$thebean->setAlternate($Bean->ALTERNATE);
				$thebean->setPosition($Bean->POSITION);
				$thebean->setInfos($docInfoDAO->getAllByDocument($thebean));
				$thebean->setValues($propValDAO->getAllByDocument($thebean));
				//$typeDoc = $typDocDAO->getByIdWithValues((int)$Bean->TYPE_DOCUMENT,$thebean);
				$thebean->setTypeDocument($typDocDAO->getById((int)$Bean->TYPE_DOCUMENT));
				
			}
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $thebean;
	}
	function getSummaryById($id){
		try
		{
			$id =StringHelper::escapeSql($id);
			$query="select ID,OWNER_ID,GROUP_ID,PERM_BIN,VISIBLE,ALTERNATE from DOCUMENTS where id=$id;";
			
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = new Document((int)$Bean->ID);
				$thebean->setGroupId((int)$Bean->GROUP_ID);
				$thebean->setOwnerId((int)$Bean->OWNER_ID);
				$thebean->setPermission($Bean->PERM_BIN);
				$thebean->setVisible($Bean->VISIBLE);
				$thebean->setAlternate($Bean->ALTERNATE);
			}
		}
		catch(Exception $e)     {
			echo $query;
			//throw $e;
		}

		return $thebean;
	}
	function remove($Bean){
		try{
			$docInfDAO = $this->factory->getDocumentInfoDAO();
			$valDAO = $this->factory->getPropertyValueDAO();
			foreach ($Bean->getInfos() as $Inf){
				$docInfDAO->remove($Inf);
			}
			foreach ($Bean->getValues() as $Value){
				$valDAO->remove($Value);
			}
			$query="delete from DOCUMENTS where id=".StringHelper::escapeSql($Bean->getId()).";";
			$this->pdo->exec($query);
			$bool=true;
		}catch(Exception $e)    {
			$bool=false;
		}
		return $bool;

	}
	function update($Bean){
		try{
			
			$infoDAO = $this->factory->getDocumentInfoDAO();
			$typeDAO = $this->factory->getTypeDocumentDAO();
			if(!is_null($Bean->getInfos())){
				foreach ($Bean->getInfos() as $Info){
					$infoDAO->update($Info);
				}
			}
			if(!is_null($Bean->getValues())){
				$valDAO = $this->factory->getPropertyValueDAO();
				foreach ($Bean->getValues() as $Value){
					if($Value->getId()==0){
						
						$Value->setDocumentId((int)$Bean->getId());
						$valDAO->add($Value);
					}else{
						
						$valDAO->update($Value);
					}
				}
			}
			$typeDAO->update($Bean->getTypeDocument());
			$query = "update DOCUMENTS set TYPE_DOCUMENT=".StringHelper::escapeSql($Bean->getTypeDocument()->getId())." ,";
			$query .= "parent_cat_id=".StringHelper::escapeSql($Bean->getParentCategoryId()).", ";
			$query .= "PERM_BIN='".StringHelper::escapeSql($Bean->getPermission())."', ";
			$query .= "OWNER_ID=".StringHelper::escapeSql($Bean->getOwnerId())." ,GROUP_ID=".StringHelper::escapeSql($Bean->getGroupId()).", ";
			$query .= "POSITION = ".StringHelper::escapeSql($Bean->getPosition()).", ";
			$query .= "ALTERNATE = '".StringHelper::escapeSql($Bean->getAlternate())."', ";
			$query .= "UPDATED = NOW(), ";
			$query .= "VISIBLE = ".StringHelper::escapeSql($Bean->isVisible());
			$query .= " where id=".StringHelper::escapeSql($Bean->getId()).";";
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
			if ((int)$Bean->getId() == 0){
				
				$posQuery="(select count(*)as CPT from CATEGORIES where PARENT_CAT_ID = ".StringHelper::escapeSql($Bean->getParentCategoryId()).")";
				$statement=$this->pdo->query($posQuery);
				$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
				$pos = (int)$array_obj[0]->CPT;
				$pos = $pos+1;
				$thebean = null;
				
				$insertQuery = "insert into DOCUMENTS (parent_cat_id,type_document,PERM_BIN,GROUP_ID,OWNER_ID, VISIBLE,ALTERNATE,CREATED,UPDATED,POSITION) values ";
				$insertQuery .= "(";
				$insertQuery .= StringHelper::escapeSql($Bean->getParentCategoryId()).",";
				$insertQuery .= StringHelper::escapeSql($Bean->getTypeDocument()->getId()).",'".StringHelper::escapeSql($Bean->getPermission())."',";
				$insertQuery .= StringHelper::escapeSql($Bean->getGroupId()).",".StringHelper::escapeSql($Bean->getOwnerId()).", 1, '".StringHelper::escapeSql($Bean->getAlternate());
				$insertQuery .= "',NOW(),NOW(),".$pos;
				$insertQuery .= ");";
				$this->pdo->exec($insertQuery);
				$thebean = $this->getById((int)$this->pdo->lastInsertId());
				
				if(!is_null($Bean->getInfos())){
					$infoDAO = $this->factory->getDocumentInfoDAO();
					foreach ($Bean->getInfos() as $Info){
						$Info->setDocumentId((int)$thebean->getId());
						
						$infoDAO->add($Info);
					}
				}
				if(!is_null($Bean->getValues())){
					$valDAO = $this->factory->getPropertyValueDAO();
					foreach ($Bean->getValues() as $Value){
						$Value->setDocumentId((int)$thebean->getId());
						$valDAO->add($Value);
					}
				}
			}
		}catch(Exception $e)    {throw $e;}
		return $thebean;
	}
	function getAllByCategory($Category){
		try
		{
			if(is_a($Category, 'Category')){
				$BeanArray = array();
				$query="select * from DOCUMENTS where parent_cat_id=".StringHelper::escapeSql($Category->getId())." order by position asc;";
				$statement=$this->pdo->query($query);
				$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
				$thebean = null;
				foreach($array_obj as $Bean){
					$thebean = $this->getById((int)$Bean->ID);
					array_push($BeanArray,$thebean);
				}
			}
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $BeanArray;

	}
	function getAutoCompleteLookup($querystring){
		try
		{
			$BeanArray = array();
			$iso = $_SESSION['langue'];
			$query="SELECT distinct(d.ID) as ID  FROM DOCUMENTS as d,PROPERTY_VALUES as v,DOCUMENT_INFO as i where v.DOCUMENT_ID = d.ID and i.DOC_ID = d.ID and i.LNG_ID=(select ID from LANGUES where ISO='".$iso."') and v.LNG_ID =(select ID from LANGUES where ISO='".$iso."') and (i.LABEL like '".StringHelper::escapeSql($querystring)."%' or i.TOOLTIP like '".StringHelper::escapeSql($querystring)."%' )  LIMIT 10;";
			//$query="SELECT ID FROM DOCUMENTS WHERE value LIKE ".StringHelper::escapeSql($querystring)." LIMIT 10";
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
	function getAllByTypeDocument($TypeDocument){
		try
		{
			if(is_a($TypeDocument, 'TypeDocument')){
				$BeanArray = array();
				$query="select * from DOCUMENTS where TYPE_DOCUMENT=".StringHelper::escapeSql($TypeDocument->getId())." order by parent_cat_id asc, position asc;";
				$statement=$this->pdo->query($query);
				$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
				$thebean = null;
				foreach($array_obj as $Bean){
					$thebean = $this->getById((int)$Bean->ID);
					array_push($BeanArray,$thebean);
				}
			}
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $BeanArray;

	}
}
?>