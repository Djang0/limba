<?php
/**
 * @package limba.dao
 * @author  Ludovic Reenaers
 * @since 2 fev. 2011
 * 
 * @link http://code.google.com/p/limba
 */

class WordDAO extends DAO{
	public function getById($id){
		try
		{
			$id =StringHelper::escapeSql($id);
			$query="select * from WORDS where ID=$id;";
			$transDAO = $this->factory->getTranslationDAO();
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = new Word((int)$Bean->ID);
				$thebean->setLabel($Bean->NAME);
				$thebean->setTranslations($transDAO->getAllByWord($thebean));
				$thebean->setListeId($Bean->LIST_ID);
			}
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $thebean;
	}
	function remove($Bean){
		try{
			
			$transDAO = $this->factory->getTranslationDAO();
			if(!is_null($Bean->getTranslations())){
				foreach ($Bean->getTranslations() as $Trans){
					$transDAO->remove($Trans);
				}
			}
			$query="delete from WORDS where id='".StringHelper::escapeSql($Bean->getId())."';";
			$this->pdo->exec($query);
			$bool=true;
		}catch(Exception $e)    {
			$bool=false;
		}
		return $bool;

	}
	
	function update($Bean){
		try{
			$transDAO = $this->factory->getTranslationDAO();
			if(!is_null($Bean->getTranslations())){
				foreach ($Bean->getTranslations() as $Trans){
					$transDAO->update($Trans);
				}
			}
			$query = "update WORDS set NAME='".StringHelper::escapeSql($Bean->getLabel());
			$query .= "' where id=".StringHelper::escapeSql($Bean->getId()).";";
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
			$transDAO = $this->factory->getTranslationDAO();
			if(!is_null($Bean->getTranslations())){
				foreach ($Bean->getTranslations() as $Trans){
					$transDAO->add($Trans);
				}
			}
			$insertQuery = "insert into WORDS (NAME,LIST_ID) ";
			$insertQuery .= "values ('".StringHelper::escapeSql($Bean->getLabel());
			$insertQuery .= "',";
			if(is_null($Bean->getListeId())){
				$insertQuery .= 'NULL';	
			}else{
				$insertQuery .= StringHelper::escapeSql($Bean->getListeId());
			}
			$insertQuery .= ");";
			$thebean = null;
			$this->pdo->exec($insertQuery);
			$thebean = $this->getById((int)$this->pdo->lastInsertId());

		}catch(Exception $e)    {throw $e;}
		return $thebean;
	}
	function getAll(){
		try
		{
			$BeanArray = array();
			$query="select * from WORDS;";
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
	function AllByListe($thebean){
		try
		{
			$BeanArray = array();
			$query="select * from WORDS where LIST_ID=".StringHelper::escapeSql($thebean->getId()).";";
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
}
?>