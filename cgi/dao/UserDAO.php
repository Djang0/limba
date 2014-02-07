<?php
/**
 * @package limba.dao
 * @author  Ludovic Reenaers
 * @since 21 mars 2009
 * 
 * @link http://code.google.com/p/limba
 */

class UserDAO extends DAO{


	function getById($id){
		try
		{
			$id = StringHelper::escapeSql($id);
			$query="select * from USER where id=$id;";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = new User((int)$Bean->ID);
				$thebean->setName($Bean->NAME);
				$thebean->setSurname($Bean->SURNAME);
				//$thebean->setPseudo($Bean->PSEUDO);
				$thebean->setEmail($Bean->EMAIL);
				$thebean->setStreet($Bean->STREET);
				$thebean->setNumber($Bean->NUMBER);
				$thebean->setZip($Bean->ZIP);
				$thebean->setCity($Bean->CITY);
				$thebean->setCountry($Bean->COUNTRY);
				$thebean->setLangue($this->factory->getLangueDAO()->getById((int)$Bean->LANGUE_ID));
				if(!is_null($Bean->LAST_IP)){
					$thebean->setIp($Bean->LAST_IP);
				}
				
				list($year,$month,$day)=preg_split('/[-\.\/ ]/',$Bean->DDN);
				$thebean->setDdn($day,$month,$year);
				$thebean->setCreated($Bean->CREATED);
				$thebean->setLastConnected($Bean->LAST_CONNECTED);
				$thebean->setPwsHash($Bean->PWS_HASH,$Bean->PWS_HASH);

				$thebean->setGroups($this->factory->getProfileDAO()->getByUser($thebean));
				$thebean->setActive($Bean->ACTIVE);
			}
		}
		catch(Exception $e)     {
			throw $e;
			 
		}

		return $thebean;
	}

	function add($bean){
		$thebean = null;
		if (is_null($bean->getId())||$bean->getId()==0){
			$stamp = time();
			$query="insert into USER (name,surname,pseudo,email,street,number,zip,city,country,langue_id,last_ip,ddn,pws_hash,created,last_connected)";
			$query.=" values ('".StringHelper::escapeSql($bean->getName())."','".StringHelper::escapeSql($bean->getSurname())."','".StringHelper::escapeSql($bean->getPseudo())."','".StringHelper::escapeSql($bean->getEmail())."','".StringHelper::escapeSql($bean->getStreet())."','".StringHelper::escapeSql($bean->getNumber())."','".StringHelper::escapeSql($bean->getZip())."','".StringHelper::escapeSql($bean->getCity())."','".StringHelper::escapeSql($bean->getCountry())."',".StringHelper::escapeSql($bean->getLangue()->getId()).",'".StringHelper::escapeSql($bean->getIp())."',DATE('".StringHelper::escapeSql($bean->getDdn())."'),'".StringHelper::escapeSql($bean->getPwsHash())."',NOW(),NOW());";
			try{
				$this->pdo->exec($query);
				$thebean = $this->getById((int)$this->pdo->lastInsertId());
			}catch(Exception $e){
				 
				echo $e->getMessage();
			}
		}
		return $thebean;
	}
	function getByEmail($email){

		try
		{
			$email = StringHelper::escapeSql($email);
			$query="select * from USER where lcase(email)='".strtolower($email)."';";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = $this->getById((int)$Bean->ID);
			}
		}
		catch(Exception $e)     {
			
			throw $e;
		}

		return $thebean;
	}

	function getAnonymousUser(){
		 
		try
		{
			
			$query="select ID from USER where EMAIL='anonymous@host.com';";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = $this->getById((int)$Bean->ID);
			}
		}
		catch(Exception $e)     {
			throw $e;
			echo $query;
		}

		return $thebean;
	}
	public function updateSecInfo($Bean){
		try{
			$query = "update USER set ";
			
			if(!is_null($Bean->getIp())){
				$query.="last_ip ='".StringHelper::escapeSql($Bean->getIp())."',";
			}
			$query.="last_connected = CURRENT_TIMESTAMP";
			$query.=" where id=".StringHelper::escapeSql($Bean->getId()).";";
			$this->pdo->exec($query);
			$bool=true;
		}
		catch(Exception $e)     {
			$bool=false;
			echo $e->getMessage();
		}
		return $bool;
	}
	public function update($Bean){
		try{
			$query = "update USER set name='".StringHelper::escapeSql($Bean->getName())."'";
			$query.=",surname='".StringHelper::escapeSql($Bean->getSurname())."'";
			$query.=",pseudo ='".StringHelper::escapeSql($Bean->getPseudo())."'";
			$query.=",email ='".StringHelper::escapeSql($Bean->getEmail())."'";
			$query.=",street ='".StringHelper::escapeSql($Bean->getStreet())."'";
			$query.=",number ='".StringHelper::escapeSql($Bean->getNumber())."'";
			$query.=",zip ='".StringHelper::escapeSql($Bean->getZip())."'";
			$query.=",city ='".StringHelper::escapeSql($Bean->getCity())."'";
			$query.=",country ='".StringHelper::escapeSql($Bean->getCountry())."'";
			$query.=",langue_id =".StringHelper::escapeSql($Bean->getLangue()->getId());
			if(!is_null($Bean->getIp())){
				$query.=",last_ip ='".StringHelper::escapeSql($Bean->getIp())."'";
			}
			$query.=",last_connected = CURRENT_TIMESTAMP";
			$query.=",pws_hash ='".StringHelper::escapeSql($Bean->getPwsHash())."'";
			$query.=",active =".StringHelper::escapeSql($Bean->isActive());
			$query.=",ddn =DATE('".StringHelper::escapeSql($Bean->getDdn())."')";
			$query.=" where id=".StringHelper::escapeSql($Bean->getId()).";";
			$this->pdo->exec($query);
			$bool=true;
		}
		catch(Exception $e)     {
			$bool=false;
			echo $e->getMessage();
		}
		return $bool;
	}

	public function remove($Bean){
		try{
			$queryFK="update USER set active=false where id=".StringHelper::escapeSql($Bean->getId()).";";
			$this->pdo->exec($query);
			$bool=true;
		}catch(Exception $e)    {
			$bool=false;
		}
		return $bool;
	}
	function getAll(){

		try
		{
			
			$query="select * from USER;";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$thebean = null;
			$tab = array();
			foreach($array_obj as $Bean){
				$thebean = $this->getById((int)$Bean->ID);
				array_push($tab, $thebean);
			}
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $tab;
	}
}
?>