<?php
/**
 * @package limba.dao
 * @author  Ludovic Reenaers
 * @since 24 janv. 2009
 * 
 * @link http://code.google.com/p/limba
 */
class DocumentInfoDAO extends DAO{


	function getById($id){
		try
		{
			$id=StringHelper::escapeSql($id);
			$query="select * from DOCUMENT_INFO where id=$id;";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$lngDAO = $this->factory->getLangueDAO();
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = new DocumentInfo((int)$Bean->ID);
				$thebean->setLabel($Bean->LABEL);
				$thebean->setTooltip($Bean->TOOLTIP);
				$thebean->setDocumentId((int)$Bean->DOC_ID);
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
			$query="delete from DOCUMENT_INFO where id='".StringHelper::escapeSql($Bean->getId())."';";
			$this->pdo->exec($query);
			$bool=true;
		}catch(Exception $e)    {
			$bool=false;
		}
		return $bool;

	}
	function update($Bean){
		try{
			$query = "update DOCUMENT_INFO set label='".StringHelper::escapeSql($Bean->getLabel())."',tooltip='".StringHelper::escapeSql($Bean->getTooltip())."' where id=".StringHelper::escapeSql($Bean->getId()).";";
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
			if ((int)$Bean->getId() == 0){
				$insertQuery = "insert into DOCUMENT_INFO (label,tooltip,lng_id,doc_id) values ('".StringHelper::escapeSql($Bean->getLabel())."','".StringHelper::escapeSql($Bean->getTooltip())."',".StringHelper::escapeSql($Bean->getLangue()->getId()).",".StringHelper::escapeSql($Bean->getDocumentId()).");";
				
				$this->pdo->exec($insertQuery);
				$thebean = null;
				$thebean = $this->getById((int)$this->pdo->lastInsertId());
			}
		}catch(Exception $e)    {
			echo $insertQuery;
			throw $e;
		}
		return $thebean;
	}
	function getAllByDocument($Document){
		try
		{
			if(is_a($Document, 'Document')){
				$BeanArray = array();
				$query="select * from DOCUMENT_INFO where doc_id=".StringHelper::escapeSql($Document->getId()).";";
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
	function getAllByDocumentByLangue($Document,$Langue){
		try
		{
			if(is_a($Document, 'Document')&& is_a($Langue, 'Langue')){
				$BeanArray = array();
				$query="select * from DOCUMENT_INFO where doc_id=".StringHelper::escapeSql($Document->getId())." and lng_id=".StringHelper::escapeSql($Langue->getId()).";";
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