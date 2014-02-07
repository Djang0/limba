<?php
/**
 * @package limba.dao
 * @author  Ludovic Reenaers
 * @since 24 janv. 2009
 * 
 * @link http://code.google.com/p/limba
 */
class LangueLabelDAO extends DAO{

	public function getById($id){
		try
		{
			$id =StringHelper::escapeSql($id);
			$query="select * from LANGUE_INFO as i join LANGUES as l where i.id=$id and i.langue_traduction_id=l.id";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = new LangueLabel((int)$Bean->ID);
				$thebean->setLabel($Bean->LABEL);
				$thebean->setlangueId((int)$Bean->LANGUE_ID);
				$thebean->setIsoTraduction($Bean->ISO);
			}
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $thebean;
	}
	public function getAllByLangue($Bean){
		try
		{
			$BeanArray = array();
			$query="select * from LANGUE_INFO where langue_id=".StringHelper::escapeSql($Bean->getId()).";";
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
	public function update($Bean){
		try{
			$query = "update LANGUE_INFO set label='".StringHelper::escapeSql($Bean->getLabel())."' where id=".StringHelper::escapeSql($Bean->getId()).";";
			$this->pdo->exec($query);
			$bool=true;
		}
		catch(Exception $e)     {
			$bool=false;
			 
		}
		return $bool;
	}
	public function Add($Bean){
		try{
			if (is_null($Bean->getId()) || (int)$Bean->getId() == 0){
				echo "adding";
				$insertQuery = "insert into LANGUE_INFO (langue_id,label,langue_traduction_id) values (".StringHelper::escapeSql($Bean->getLangueId()).",'".StringHelper::escapeSql($Bean->getLabel())."',(select id from LANGUES where iso='".StringHelper::escapeSql($Bean->getIsoTraduction())."'));";
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
	public function remove($Bean){
		try{
			$bool = false;
			$query="update LANGUE_INFO set label='' where id=".StringHelper::escapeSql($Bean->getId()).";";
			$this->pdo->exec($query);
			$bool=true;
		}catch(Exception $e)    {
			$bool=false;
		}
		return $bool;
	}

}