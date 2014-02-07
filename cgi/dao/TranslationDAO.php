<?php
/**
 * @package limba.dao
 * @author  Ludovic Reenaers
 * @since 4 nov. 2010
 * 
 * @link http://code.google.com/p/limba
 */

class TranslationDAO extends DAO{
	public function getById($id){
		try
		{
			$id =StringHelper::escapeSql($id);
			$query="select * from TRANSLATION where ID=$id;";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$lngDAO = $this->factory->getLangueDAO();
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = new Translation((int)$Bean->ID);
				$thebean->setLabel($Bean->LABEL);
				$thebean->setWordId((int)$Bean->WORD_ID);
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
			$query="delete from TRANSLATION where id='".StringHelper::escapeSql($Bean->getId())."';";
			$this->pdo->exec($query);
			$bool=true;
		}catch(Exception $e)    {
			$bool=false;
		}
		return $bool;

	}
	
	function update($Bean){
		try{
			$query = "update TRANSLATION set LABEL='".StringHelper::escapeSql($Bean->getLabel());
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
			$insertQuery = "insert into TRANSLATION (LABEL,LNG_ID,WORD_ID) ";
			$insertQuery .= "values ('".StringHelper::escapeSql($Bean->getLabel());
			$insertQuery .= "',".StringHelper::escapeSql($Bean->getLangue()->getId()).",".StringHelper::escapeSql($Bean->getWordId()).");";
			$thebean = null;
			$this->pdo->exec($insertQuery);
			$thebean = $this->getById((int)$this->pdo->lastInsertId());

		}catch(Exception $e)    {throw $e;}
		return $thebean;
	}
	function getAllByWord($Word){
		try
		{
			if(is_a($Word, "Word")){
				$BeanArray = array();
				$query="select * from TRANSLATION where WORD_ID=".StringHelper::escapeSql($Word->getId()).";";
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
	function getByWordByLangue($iso,$name){
		try
		{
			$query="select t.ID as ID from TRANSLATION as t,WORDS as w, LANGUES as l where t.WORD_ID=w.ID and t.LNG_ID=l.ID and l.ISO='".StringHelper::escapeSql($iso)."' and w.NAME='".StringHelper::escapeSql($name)."';";
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
}
?>