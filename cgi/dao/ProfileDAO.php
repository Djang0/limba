<?php
/**
 * @package limba.dao
 * @author  Ludovic Reenaers
 * @since 4 nov. 2010
 * 
 * @link http://code.google.com/p/limba
 */
class ProfileDAO extends DAO{


	function getById($id){
		try
		{
			$id = StringHelper::escapeSql($id);
			$query="select * from PROFILE where ID=$id;";
			 
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$TokenDAO = $this->factory->getTokenDAO();
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = new Profile((int)$Bean->ID);
				$thebean->setLabel($Bean->LABEL);
				$thebean->setComment($Bean->COMMENT);
				$thebean->setAvailable($Bean->AVAILABLE);
				$thebean->setTokens($TokenDAO->getByProfile($thebean));
			}
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $thebean;
	}
	function getByUser($bean){
		try
		{
			$BeanArray = array();
			$query="select g.PROFILE_ID as ID from USER as u, GROUPS as g where g.USER_ID = u.ID and g.USER_ID=".$bean->getId().";";
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
	function getByLabel($labelstr){
		try
		{
			$labelstr = StringHelper::escapeSql($labelstr);
			$query="select * from PROFILE where LABEL='$labelstr';";

			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$TokenDAO = $this->factory->getTokenDAO();
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = new Profile((int)$Bean->ID);
				$thebean->setLabel($Bean->LABEL);
				$thebean->setComment($Bean->COMMENT);
				$thebean->setAvailable($Bean->AVAILABLE);
				$thebean->setTokens($TokenDAO->getByProfile($thebean));
			}
		}
		catch(Exception $e)     {
			throw $e;
		}
		 
		return $thebean;
		 
	}
	function remove($Bean){
		try{
			 
			$query="update PROFILE set AVAILABLE = false where ID=".StringHelper::escapeSql($Bean->getId()).";";
			$this->pdo->exec($query);
			$bool=true;
		}catch(Exception $e)    {
			$bool=false;
		}
		return $bool;

	}

	function update($Bean){
		try{
			$query = "update PROFILE set LABEL='".StringHelper::escapeSql($Bean->getLabel())."',COMMENT='".StringHelper::escapeSql($Bean->getComment())."',AVAILABLE =".StringHelper::escapeSql($Bean->getAvailable())." where ID=".StringHelper::escapeSql($Bean->getId()).";";
			$this->pdo->exec($query);
			$tokenDAO = $this->factory->getTokenDAO();
			$rmquery = "delete from  TOKENS where PROFILE_ID=".StringHelper::escapeSql($Bean->getId()).";";
			$this->pdo->exec($rmquery);
			foreach ($Bean->getTokens() as $token){
				$joinQuery = "insert into TOKENS (PROFILE_ID,TOKEN_ID) VALUES (".StringHelper::escapeSql($Bean->getId()).",".StringHelper::escapeSql($token->getId()).");";
				$this->pdo->exec($joinQuery);
			}
			$bool=true;
		}
		catch(Exception $e)     {
			$bool=false;
			 
		}
		return $bool;
	}
	function add($Bean){

		try{
			if (is_null($Bean->getId())|| (int)$Bean->getId() == 0){
				$insertQuery = "insert PROFILE (LABEL,COMMENT,AVAILABLE) values ('".StringHelper::escapeSql($Bean->getLabel())."','".StringHelper::escapeSql($Bean->getComment())."',".StringHelper::escapeSql($Bean->getAvailable()).");";
				$this->pdo->exec($insertQuery);
				$thebean = null;
				$thebean = $this->getById((int)$this->pdo->lastInsertId());
			}else{
				
				$this->update($Bean);
			}
		}catch(Exception $e)    {
			throw $e;
		}
		return $thebean;
	}
	function getAll(){
		try
		{
			$query="select * from PROFILE;";

			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$TokenDAO = $this->factory->getTokenDAO();
			$thebean = null;
			$tab = array();
			foreach($array_obj as $Bean){
				$thebean = new Profile((int)$Bean->ID);
				$thebean->setLabel($Bean->LABEL);
				$thebean->setComment($Bean->COMMENT);
				$thebean->setAvailable($Bean->AVAILABLE);
				$thebean->setTokens($TokenDAO->getByProfile($thebean));
				array_push($tab, $thebean);
			}
		}
		catch(Exception $e)     {
			throw $e;
		}
		 
		return $tab;
		 
	}

}