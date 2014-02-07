<?php
/**
 * @package limba.dao
 * @author  Ludovic Reenaers
 * @since 24 janv. 2009
 * 
 * @link http://code.google.com/p/limba
 */
class CategoryInfoDAO extends DAO{


	function getById($id){
		try
		{
			$id = StringHelper::escapeSql($id);
			$query="select * from CATEGORIES_INFO where id=$id;";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$lngDAO = $this->factory->getLangueDAO();
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = new CategoryInfo((int)$Bean->ID);
				$thebean->setLabel($Bean->LABEL);
				$thebean->setTooltip($Bean->TOOLTIP);
				$thebean->setCategoryId((int)$Bean->CAT_ID);
				$thebean->setLangue($lngDAO->getById((int)$Bean->LNG_ID));
			}
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $thebean;
	}
	function remove($Bean){
		try{
			$query="delete from CATEGORIES_INFO where id='".StringHelper::escapeSql($Bean->getId())."';";
			$this->pdo->exec($query);
			$bool=true;
		}catch(Exception $e)    {
			$bool=false;
		}
		return $bool;

	}
	function update($Bean){
		try{
			$query = "update CATEGORIES_INFO set LABEL='".StringHelper::escapeSql($Bean->getLabel())."',TOOLTIP='".StringHelper::escapeSql($Bean->getTooltip())."' where ID=".StringHelper::escapeSql($Bean->getId()).";";
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
			if (is_null($Bean->getId())|| $Bean->getId() == 0){
				$insertQuery = "insert into CATEGORIES_INFO (label,tooltip,lng_id,cat_id) values ('".StringHelper::escapeSql($Bean->getLabel())."','".StringHelper::escapeSql($Bean->getTooltip())."',".StringHelper::escapeSql($Bean->getLangue()->getId()).",".StringHelper::escapeSql($Bean->getCategoryId()).");";
				$this->pdo->exec($insertQuery);
				$thebean = null;
				$thebean = $this->getById((int)$this->pdo->lastInsertId());
			}
		}catch(Exception $e)    {throw $e;}
		return $thebean;
	}
	function getAllByCategory($Category){
		try
		{
			if(is_a($Category, 'Category')){
				$BeanArray = array();
				$query="select * from CATEGORIES_INFO where cat_id=".StringHelper::escapeSql($Category->getId()).";";
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
	function getAllByCategoryByLangue($Category,$Langue){
		try
		{
			if(is_a($Category, 'Category')&& is_a($Langue, 'Langue')){
				$BeanArray = array();
				$query="select * from CATEGORIES_INFO where cat_id=".StringHelper::escapeSql($Category->getId())." and lng_id=".StringHelper::escapeSql($Langue->getId()).";";
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