<?php
/**
 * @package limba.dao
 * @author  Ludovic Reenaers
 * @since 4 nov. 2010
 * 
 * @link http://code.google.com/p/limba
 */
class PropertyValueDAO extends DAO{
	

	function getById($id){
		try
		{
			$id =StringHelper::escapeSql($id);
			$query="select * from PROPERTY_VALUES where id=$id;";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$langueDAO = $this->factory->getLangueDAO();
			
			//$wordDAO = $this->factory->getWordDAO();
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = new PropertyValue((int)$Bean->ID);
				$thebean->setPropertyId((int)$Bean->PROP_ID);
				$thebean->setChildDocId((int)$Bean->CHILD_DOC_ID);
				$thebean->setDocumentId((int)$Bean->DOCUMENT_ID);
				$thebean->setValueShort($Bean->VALUE_SHORT);
				$thebean->setValueTextFromDB($Bean->VALUE_TEXT);
				if(!is_null($Bean->VALUE_DATE_FROM)){
					$thebean->setDateFrom($Bean->VALUE_DATE_FROM,"YMD");
				}
				if(!is_null($Bean->VALUE_DATE_TO)){
					$thebean->setDateTo($Bean->VALUE_DATE_TO,"YMD");
				}
				$thebean->setDuration($Bean->DURATION);
				$thebean->setChecked($Bean->CHECKED);
				$thebean->setLangue($langueDAO->getById((int)$Bean->LNG_ID));
				if(!is_null($Bean->WORD_ID)){
					$thebean->setWordId((int)$Bean->WORD_ID);
				}
			}
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $thebean;
	}
	function remove($Bean){
		try{
			$query="delete from PROPERTY_VALUES where id='".StringHelper::escapeSql($Bean->getId())."';";
			$this->pdo->exec($query);
			$bool=true;
		}catch(Exception $e)    {
			$bool=false;
		}
		return $bool;

	}
	function update($Bean){
		try{
			$query = "update PROPERTY_VALUES set prop_id=".StringHelper::escapeSql($Bean->getPropertyId()).",CHILD_DOC_ID=".StringHelper::escapeSql($Bean->getChildDocId()).","; 
			$query.= "lng_id=".StringHelper::escapeSql($Bean->getLangue()->getId()).",";
			$query.= "value_short='".StringHelper::escapeSql($Bean->getValueShort())."'";
			$query.= ",value_text='".$Bean->getValueText()."'";
			$query.=",DOCUMENT_ID=".StringHelper::escapeSql($Bean->getDocumentId())."";
			$lsval =$Bean->getWordId();
			if(!is_null($lsval)){
				$query.= ",WORD_ID=".StringHelper::escapeSql($lsval);
			}
			if(!is_null($Bean->getDateFrom()) && strlen(str_replace(' ', '', StringHelper::escapeSql($Bean->getDateFrom())))>0){
				
				$query.= ",value_date_from=DATE('".StringHelper::escapeSql($Bean->getDateFrom())."')";
			}
			if(!is_null($Bean->getDateTo()) && strlen(str_replace(' ', '', StringHelper::escapeSql($Bean->getDateTo())))>0){
				$query.= ",value_date_to=DATE('".StringHelper::escapeSql($Bean->getDateTo())."')";
			}
			if(!is_null($Bean->getDuration()) && strlen(str_replace(' ', '', StringHelper::escapeSql($Bean->getDuration())))>0){
				$query.= ",duration=".StringHelper::escapeSql($Bean->getDuration());
			}
			if(!is_null($Bean->getChecked())){
				$query.= ",checked=".StringHelper::escapeSql($Bean->getChecked());
			}
			$query.=" where id=".StringHelper::escapeSql($Bean->getId()).";";
			$this->pdo->exec($query);
			$bool=true;
		}catch(Exception $e)     {
			$bool=false;
			throw $e;
		}
		return $bool;
	}
	function add($Bean){
		 
		try{
			 
			if ((int)$Bean->getId()==0){
				$insertQuery = "insert into PROPERTY_VALUES (prop_id,lng_id,value_short,value_text,DOCUMENT_ID,WORD_ID,value_date_from,value_date_to,duration,CHILD_DOC_ID,checked) values";
				$insertQuery .=" (".StringHelper::escapeSql($Bean->getPropertyId()).",".StringHelper::escapeSql($Bean->getLangue()->getId()).",";
				$insertQuery .="'".StringHelper::escapeSql($Bean->getValueShort())."','".$Bean->getValueText()."',";
				$insertQuery .=StringHelper::escapeSql($Bean->getDocumentId()).",";
				if(!is_null($Bean->getWordId())){
					$insertQuery .=StringHelper::escapeSql($Bean->getWordId()).",";
				}else{
					$insertQuery .="null,";
				}
				if(!is_null($Bean->getDateFrom())){
					$insertQuery .="DATE('".StringHelper::escapeSql($Bean->getDateFrom())."'),";
				}else{
					$insertQuery .="null,";
				}
				if(!is_null($Bean->getDateTo())){
					$insertQuery .="DATE('".StringHelper::escapeSql($Bean->getDateTo())."'),";
				}else{
					$insertQuery .="null,";
				}
				if(!is_null($Bean->getDuration())){
					$insertQuery .=StringHelper::escapeSql($Bean->getDuration()).",";
				}else{
					$insertQuery .="null,";
				}
				if(!is_null($Bean->getChildDocId())){
					$insertQuery .= StringHelper::escapeSql($Bean->getChildDocId()).",";
				}else{
					$insertQuery .="null,";
				}
				if(!is_null($Bean->getChecked())){
					$insertQuery .=StringHelper::escapeSql($Bean->getChecked()).");";	
				}else{
					$insertQuery .="null);";
				}
				echo $insertQuery;
				
				$this->pdo->exec($insertQuery);
				$thebean = null;
				$thebean = $this->getById((int)$this->pdo->lastInsertId());
			}
		}catch(Exception $e)    {
			
			throw $e;
		}
		return $thebean;
	}

	function All(){
		try
		{

			$BeanArray = array();
			$query="select * from PROPERTY_VALUES;";
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
	function getAllByDocument($Document){
		try
		{

			$BeanArray = array();
			$query="select * from PROPERTY_VALUES where DOCUMENT_ID=".StringHelper::escapeSql($Document->getId()).";";
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
	function getAllByPropertyByDocument($Document,$Property){
		try
		{

			$BeanArray = array();
			$query="select * from PROPERTY_VALUES where prop_id=".StringHelper::escapeSql($Property->getId())." and DOCUMENT_ID=".StringHelper::escapeSql($Document->getId()).";";
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
	//TODO: deprecated
	function getByPropertyByDocumentUsingIds($docid,$propid,$iso){
		try
		{

			
			$query="select p.ID as ID from PROPERTY_VALUES as p, LANGUES as l where p.LNG_ID = l.ID and prop_id=".StringHelper::escapeSql($propid)." and DOCUMENT_ID=".StringHelper::escapeSql($docid)." and l.ISO='".StringHelper::escapeSql($iso)."';";
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
	function getAllUsingIds($docid,$propid,$iso){
		try
		{

			
			$query="select p.ID as ID from PROPERTY_VALUES as p, LANGUES as l where p.LNG_ID = l.ID and prop_id=".StringHelper::escapeSql($propid)." and DOCUMENT_ID=".StringHelper::escapeSql($docid)." and l.ISO='".StringHelper::escapeSql($iso)."';";
			$statement=$this->pdo->query($query);			
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$beanList = array();
			foreach($array_obj as $Bean){

				array_push($beanList,$this->getById((int)$Bean->ID)) ;
				
			}
				
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $beanList;

	}
}

?>