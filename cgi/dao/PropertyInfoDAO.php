<?php
/**
 * @package limba.dao
 * @author  Ludovic Reenaers
 * @since 4 nov. 2010
 * 
 * @link http://code.google.com/p/limba
 */
class PropertyInfoDAO extends DAO{


	function getById($id){
		try
		{
			$id =StringHelper::escapeSql($id);
			$query="select * from PROPERTY_INFO where id=$id;";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$lngDAO = $this->factory->getLangueDAO();
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = new PropertyInfo((int)$Bean->ID);
				$thebean->setLabel($Bean->LABEL);
				$thebean->setTooltip($Bean->TOOLTIP);
				$thebean->setPropertyId((int)$Bean->PROP_ID);
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
			$query="delete from PROPERTY_INFO where id='".StringHelper::escapeSql($Bean->getId())."';";
			$this->pdo->exec($query);
			$bool=true;
		}catch(Exception $e)    {
			$bool=false;
		}
		return $bool;

	}
	function update($Bean){
		try{
			$query = "update PROPERTY_INFO set label='".StringHelper::escapeSql($Bean->getLabel())."',tooltip=".StringHelper::escapeSql($Bean->getTooltip())." where id=".StringHelper::escapeSql($Bean->getId()).";";
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
				$insertQuery = "insert into PROPERTY_INFO (LABEL,TOOLTIP,LNG_ID,PROP_ID) values ('".StringHelper::escapeSql($Bean->getLabel())."','".StringHelper::escapeSql($Bean->getTooltip())."',".StringHelper::escapeSql($Bean->getLangue()->getId()).",".StringHelper::escapeSql($Bean->getPropertyId()).");";
				$this->pdo->exec($insertQuery);
				$thebean = null;
				$thebean = $this->getById((int)$this->pdo->lastInsertId());
			}
		}catch(Exception $e)    {$this->pdo->message;}
		return $thebean;
	}
	function getAllByProperty($Property){
		try
		{
			if(is_a($Property, 'Property')){
				$BeanArray = array();
				$query="select * from PROPERTY_INFO where PROP_ID=".StringHelper::escapeSql($Property->getId()).";";
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
	function AllByPropertyByLangue($Property,$Langue){
		try
		{
			if(is_a($Property, 'Property')&& is_a($Langue, 'Langue')){
				$BeanArray = array();
				$query="select * from PROPERTY_INFO where PROP_ID=".StringHelper::escapeSql($Property->getId())." and LNG_ID=".StringHelper::escapeSql($Langue->getId()).";";
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