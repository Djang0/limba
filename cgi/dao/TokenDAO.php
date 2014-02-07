<?php
/**
 * @package limba.dao
 * @author  Ludovic Reenaers
 * @since 4 nov. 2010
 * 
 * @link http://code.google.com/p/limba
 */

class TokenDAO extends DAO{


	function getById($id){
		//return a Token with a given id
		try
		{
			$id =StringHelper::escapeSql($id);
			$query="select * from TOKEN where id=$id;";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = new Token((int)$Bean->ID);
				$thebean->setLabel($Bean->LABEL);
			}
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $thebean;
	}

	function remove($Bean){
		try{
			$query="delete from TOKEN where ID='".StringHelper::escapeSql($Bean->getId())."';";
			$this->pdo->exec($query);
			$bool=true;
		}catch(Exception $e)    {
			$bool=false;
		}
		return $bool;

	}
	function update($Bean){
		try{
			$query = "update TOKEN set LABEL='".StringHelper::escapeSql($Bean->getLabel())."' where ID=".StringHelper::escapeSql($Bean->getId()).";";
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
			$thebean = null;
			if ($Bean->getId() == 0){
				
				$insertQuery = "insert into TOKEN (LABEL) values ('".StringHelper::escapeSql($Bean->getLabel())."');";
				$this->pdo->exec($insertQuery);
				
				$thebean = $this->getById((int)$this->pdo->lastInsertId());
				 
			}else{
				$this->update($Bean);
			}
		}catch(Exception $e)    {$this->pdo->message;}
		return $thebean;
	}
	function getByProfile($ProfBean){
		try
		{
			$BeanArray = array();
			
			$query="SELECT t.ID as ID from TOKENS as ts,TOKEN as t where ts.TOKEN_ID = t.ID and ts.PROFILE_ID=".StringHelper::escapeSql($ProfBean->getId()).";";
			
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
	function getAll(){
		try
		{
			$BeanArray = array();
			
			$query="SELECT ID from TOKEN;";
			
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