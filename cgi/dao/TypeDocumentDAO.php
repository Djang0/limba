<?php
/**
 * @package limba.dao
 * @author  Ludovic Reenaers
 * @since 24 nov. 2010
 * 
 * @link http://code.google.com/p/limba
 */
class TypeDocumentDAO extends DAO{
	public function getById($id){
		try
		{
			$id =StringHelper::escapeSql($id);
			$query="select * from TYPE_DOCUMENT where id=$id;";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$propDAO = $this->factory->getPropertyDAO();
			$thebean = null;
			foreach($array_obj as $Bean){
				
				$thebean = new TypeDocument((int)$Bean->ID);
				
				$thebean->setLabel($Bean->LABEL);
				
				$thebean->setAvailable($Bean->AVAILABLE);
				
				$thebean->setProperties($propDAO->getByTypeDocument($thebean));
				
			}
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $thebean;
	}
	public function getByLabel($label){
		try
		{
			$label =strtolower(StringHelper::escapeSql($label));
			$query="select * from TYPE_DOCUMENT where LCASE(LABEL)='$label';";
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
//	function getByIdWithValues($id,$Document){
//		try
//		{
//			$id =StringHelper::escapeSql($id);
//			$query="select * from TYPE_DOCUMENT where id=$id;";
//			$statement=$this->pdo->query($query);
//			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
//			$propDAO = $this->factory->getPropertyDAO();
//			$thebean = null;
//			foreach($array_obj as $Bean){
//				
//				$thebean = new TypeDocument((int)$Bean->ID);
//				
//				$thebean->setLabel($Bean->LABEL);
//				
//				$thebean->setAvailable($Bean->AVAILABLE);
//				
//				$thebean->setProperties($propDAO->getByDocument($Document,$id));
//				
//			}
//		}
//		catch(Exception $e)     {
//			throw $e;
//		}
//
//		return $thebean;
//		
//	}
	function remove($Bean){
		try{
			
			$query="update TYPE_DOCUMENTS set AVAILABLE= false where id=".StringHelper::escapeSql($Bean->getId())."';";
			$this->pdo->exec($query);
			$bool=true;
		}catch(Exception $e)    {
			$bool=false;
		}
		return $bool;

	}
	function update($Bean){
		try{
			
			$propDAO = $this->factory->getPropertyDAO();
			foreach ($Bean->getProperties() as $Prop){
				$propDAO->update($Prop);
			}
			$query = "update TYPE_DOCUMENT set LABEL='".StringHelper::escapeSql($Bean->getLabel())."',";
			$query.= "AVAILABLE=".StringHelper::escapeSql($Bean->isAvailable())." where ID=".StringHelper::escapeSql($Bean->getId()).";";
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
				$thebean = null;
				$propDAO = $this->factory->getPropertyDAO();
				foreach ($Bean->getProperties() as $Prop){
					$propDAO->add($Prop);
				}
				$insertQuery = "insert into TYPE_DOCUMENT (LABEL,AVAILABLE) values ('".StringHelper::escapeSql($Bean->getLabel())."',".StringHelper::escapeSql($Bean->getAvailable()).");";
				$entiteDAO = $this->factory->getEntiteDAO();
				$entiteDAO->add($Bean->getEntite());
				$this->pdo->exec($insertQuery);
				$thebean = $this->getById((int)$this->pdo->lastInsertId());
			}
		}catch(Exception $e)    {
			$this->pdo->message;
		}
		return $thebean;
	}
	public function getAll(){
		try
		{
			$query="select * from TYPE_DOCUMENT;";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$tab = array();
			foreach($array_obj as $Bean){
				$bean = $this->getById((int)$Bean->ID);
				array_push($tab, $bean);
			}
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $tab;
	}

}
?>