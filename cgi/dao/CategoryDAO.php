<?php
/**
 * @package limba.dao
 * @author  Ludovic Reenaers
 * @since 24 janv. 2009
 * @link http://code.google.com/p/limba
 */
class CategoryDAO extends DAO{


	public function getById($id){
		try
		{
			$id = StringHelper::escapeSql($id);
			$query="select * from CATEGORIES where id=$id;";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$docDAO = $this->factory->getDocumentDAO();
			$catInfoDAO = $this->factory->getCategoryInfoDAO();
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = new Category((int)$Bean->ID);
				$thebean->setParentCategoryId((int)$Bean->PARENT_CAT_ID);
				$thebean->setRootFlag((int)$Bean->IS_ROOT);
				$thebean->setChildDocuments($docDAO->getAllByCategory($thebean));
				$thebean->setInfos($catInfoDAO->getAllByCategory($thebean));
				$thebean->setGroupId((int)$Bean->GROUP_ID);
				$thebean->setOwnerId((int)$Bean->OWNER_ID);
				$thebean->setPermission($Bean->PERM_BIN);
				$thebean->setCreated($Bean->CREATED);
				$thebean->setUpdated($Bean->UPDATED);
				$thebean->setVisible($Bean->VISIBLE);
				$thebean->setAlternate($Bean->ALTERNATE);
				$thebean->setPosition($Bean->POSITION);
				$thebean->setChildCategories($this->getAllByCategory($thebean));
				
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
			$query="select ID,OWNER_ID,GROUP_ID,PERM_BIN,VISIBLE,ALTERNATE from CATEGORIES where id=$id;";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = new Category((int)$Bean->ID);
				$thebean->setGroupId((int)$Bean->GROUP_ID);
				$thebean->setOwnerId((int)$Bean->OWNER_ID);
				$thebean->setPermission($Bean->PERM_BIN);
				$thebean->setVisible($Bean->VISIBLE);
				$thebean->setAlternate($Bean->ALTERNATE);
			}
		}
		catch(Exception $e)     {
			throw $e;
		}
		return $thebean;
	}	
	function remove($Bean){
		try{
			$docDAO = $this->factory->getDocumentDAO();
			$catInfDAO = $this->factory->getCategoryInfoDAO();
			foreach ($Bean->getChildCategories() as $Cat){
				$this->remove($Cat);
			}
			foreach ($Bean->getChildDocuments() as $Doc){
				$docDAO->remove($Doc);
			}
			foreach ($Bean->getInfos() as $Inf){
				$catInfDAO->remove($Inf);
			}
			$query="delete from CATEGORIES where id='".StringHelper::escapeSql($Bean->getId())."';";
			$this->pdo->exec($query);
			$bool=true;
		}catch(Exception $e)    {
			$bool=false;
		}
		return $bool;

	}
	function update($Bean){
		try{
			$catInfDAO = $this->factory->getCategoryInfoDAO();
			foreach ($Bean->getInfos() as $Inf){
				$catInfDAO->update($Inf);
			}
			$query = "update CATEGORIES set parent_cat_id=".StringHelper::escapeSql($Bean->getParentCategoryId())." ,";
			$query .= "IS_ROOT = ".StringHelper::escapeSql($Bean->isRoot()).",PERM_BIN='".StringHelper::escapeSql($Bean->getPermission())."',";
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
			$catInfDAO = $this->factory->getCategoryInfoDAO();
			if(!is_null($Bean->getInfos())){
				foreach ($Bean->getInfos() as $Inf){
					$catInfDAO->add($Inf);
				}
			}
			$posQuery="(select count(*)as CPT from CATEGORIES where PARENT_CAT_ID = ".StringHelper::escapeSql($Bean->getParentCategoryId()).")";
			$statement=$this->pdo->query($posQuery);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$pos = (int)$array_obj[0]->CPT;
			$pos = $pos+1;
			$insertQuery = "insert into CATEGORIES (PARENT_CAT_ID,IS_ROOT,PERM_BIN,GROUP_ID,OWNER_ID, VISIBLE,ALTERNATE,CREATED,UPDATED,POSITION) ";
			$insertQuery .= "values (".StringHelper::escapeSql($Bean->getParentCategoryId()).",".StringHelper::escapeSql($Bean->isRoot()).", ";
			$insertQuery .= "'".StringHelper::escapeSql($Bean->getPermission())."',".StringHelper::escapeSql($Bean->getGroupId()).", ";
			$insertQuery .= StringHelper::escapeSql($Bean->getOwnerId()).", ".StringHelper::escapeSql($Bean->isVisible()).", '".StringHelper::escapeSql($Bean->getAlternate());
			$insertQuery .= "',NOW(),NOW(),";
			$insertQuery.= $pos;
			$insertQuery .= ");";
			$thebean = null;
			
			$this->pdo->exec($insertQuery);
			$thebean = $this->getById((int)$this->pdo->lastInsertId());

		}catch(Exception $e)    {throw $e;}
		return $thebean;
	}
	function getAllByCategory($Category){
		try
		{
			if(is_a($Category, 'Category')){
				 
				$BeanArray = array();
				$query="select * from CATEGORIES where parent_cat_id=".StringHelper::escapeSql($Category->getId())." order by position asc;";

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