<?php
/**
 * @author  Ludovic Reenaers
 * @package limba.dao
 * @since  24 janv. 2009
 * @link http://code.google.com/p/limba
 */

class LangueDAO extends DAO{


	function getById($id){
		//return a Langue with a given id
		try
		{
			$id =StringHelper::escapeSql($id);
			$query="select * from LANGUES where ID=$id;";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$DAO = $this->factory->getLangueLabelDAO();
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = new Langue((int)$Bean->ID);
				$thebean->setOrderedPosition($Bean->ORDERED);
				$thebean->setAvailable($Bean->AVAILABLE);
				$thebean->setIso($Bean->ISO);
				$thebean->setDefault($Bean->IS_DEFAULT);
				$thebean->setLabels($DAO->getAllByLangue($thebean));
				 
			}
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $thebean;
	}
	function remove($Bean){
		try{
			$query="update LANGUES set AVAILABLE=false where ID='".StringHelper::escapeSql($Bean->getId())."';";
			$this->pdo->exec($query);
			$bool=true;
		}catch(Exception $e)    {
			$bool=false;
			 
		}
		return $bool;

	}
	function getByIso($iso){
		//return a Langue with a given abr
		try
		{
			$iso =StringHelper::escapeSql($iso);
			$query="select * from LANGUES where ISO='$iso';";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = $this->getById((int)$Bean->ID);
			}
		}
		catch(Exception $e){
			echo $e;
		}

		return $thebean;
	}
	function update($Bean){
		//update a given Langue
		try{
			$query = "update LANGUES set ISO='".StringHelper::escapeSql($Bean->getIso())."',AVAILABLE=".StringHelper::escapeSql($Bean->isAvailable()).",ORDERED=".StringHelper::escapeSql($Bean->getOrderedPosition()).", IS_DEFAULT=".StringHelper::escapeSql($Bean->isDefault())." where ID=".StringHelper::escapeSql($Bean->getId()).";";
			$this->pdo->exec($query);
			$arr_labels = $Bean->getLabels();
			$DAO = $this->factory->getLangueLabelDAO();
			$thebean = null;
			if(!is_null($arr_labels)){
				foreach($arr_labels as $label){
					$DAO->update($label);
				}
			}
			$bool=true;
		}
		catch(Exception $e)     {
			$bool=false;

		}
		return $bool;
	}
	function add($Bean){
		// insert and return a new Langue
		try{
			if (is_null($Bean->getId()) || (int)$Bean->getId() == 0){
				$insertQuery = "insert into LANGUES (ISO,AVAILABLE,ORDERED,IS_DEFAULT) values ('".StringHelper::escapeSql($Bean->getIso())."',".StringHelper::escapeSql($Bean->isAvailable()).",".StringHelper::escapeSql($Bean->getOrderedPosition()).",".StringHelper::escapeSql($Bean->isDefault()).");";
				$this->pdo->exec($insertQuery);
				$thebean = null;
				$thebean = $this->getById((int)$this->pdo->lastInsertId());
				 
			}
		}catch(Exception $e)    {
			$this->pdo->message;
		}
		return $thebean;
	}
	function All(){
		try
		{
			$BeanArray = array();
			$query="select * from LANGUES order by ordered;";
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
	function getAllAvailable(){
		try
		{
			$BeanArray = array();
			$query="select * from LANGUES where AVAILABLE=1 order by ordered;";
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
	function getDefaultLanguage(){
		try
		{
			 
			$query="select * from LANGUES where AVAILABLE=1 and IS_DEFAULT=1;";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = $this->getById((int)$Bean->ID);
				// array_push($BeanArray,$thebean);
			}
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $thebean;

	}
	function getLastLangue(){
		try
		{
			 
			$query="SELECT ID FROM LANGUES WHERE ORDERED = (select max(ORDERED) from LANGUES)";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = $this->getById((int)$Bean->ID);
				// array_push($BeanArray,$thebean);
			}
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $thebean;

	}
}
?>