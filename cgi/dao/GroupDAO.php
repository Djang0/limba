<?php
/**
 * @package limba.dao
 * @author  Ludovic Reenaers
 * @since 24 janv. 2009
 * 
 * @link http://code.google.com/p/limba
 */
class GroupDAO extends DAO{
	function removeByUser($UserBean){
		try{
			 
			$query="delete from GROUPS where USER_ID=".StringHelper::escapeSql($UserBean->getId()).";";
			$this->pdo->exec($query);
			$bool=true;
		}catch(Exception $e)    {
			$bool=false;
		}
		return $bool;
	}
	function add($usrId,$profid){
		try{
			$bool=false;
			$insertQuery = "insert into GROUPS (USER_ID,PROFILE_ID) VALUES (".StringHelper::escapeSql($usrId).",".StringHelper::escapeSql($profid).")";
			$this->pdo->exec($insertQuery);
			$bool =true;
		}catch(Exception $e){
			$this->pdo->message;
		}
		return $bool;
	}
}
?>