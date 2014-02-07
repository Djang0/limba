<?php
/**
 * @package limba.dao
 * @author  Ludovic Reenaers
 * @since 4 nov. 2010
 * 
 * @link http://code.google.com/p/limba
 */
class ListeDAO extends DAO{


	function getById($id){
		try
		{
			$id =StringHelper::escapeSql($id);
			$query="select * from LIST where id=$id;";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$wordDAO = $this->factory->getWordDAO();
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = new Liste((int)$Bean->ID);
				$thebean->setLabel($Bean->LABEL);
				$thebean->setWords($wordDAO->AllByListe($thebean));
			}
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $thebean;
	}
	function remove($Bean){
		try{
			$DAO = $this->factory->getListeValueDAO();
			foreach ($Bean->getValues() as $Value){
				$DAO->remove($Value);
			}
			$query="delete from LIST where id='".StringHelper::escapeSql($Bean->getId())."';";
			$this->pdo->exec($query);
			$bool=true;
		}catch(Exception $e)    {
			$bool=false;
		}
		return $bool;

	}
	function update($Bean){
		try{
			$DAO = $this->factory->getListeValueDAO();
			foreach ($Bean->getValues() as $Value){
				$DAO->update($Value);
			}
			$query = "update LIST set label=".StringHelper::escapeSql($Bean->getLabel())." where id=".StringHelper::escapeSql($Bean->getId()).";";
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
				$DAO = $this->factory->getListeValueDAO();
				foreach ($Bean->getValues() as $Value){
					$DAO->add($Value);
				}
				$thebean = null;
				$insertQuery = "insert into LIST (label) values ('".StringHelper::escapeSql($Bean->getLabel())."');";
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
			$query="select * from LIST;";
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