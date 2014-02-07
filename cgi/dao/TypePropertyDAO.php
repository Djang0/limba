<?php
/**
 * @package limba.dao
 * @author  Ludovic Reenaers
 * @since 21 mars 2009
 * 
 * @link http://code.google.com/p/limba
 */
class TypePropertyDAO extends DAO{


	function getById($id){

		try
		{
			$id = StringHelper::escapeSql($id);
			$query="select * from TYPE_PROPERTY where id=$id;";
			$statement=$this->pdo->query($query);
			$array_obj=$statement->fetchAll(PDO::FETCH_OBJ);
			$thebean = null;
			foreach($array_obj as $Bean){
				$thebean = new TypeProperty((int)$Bean->ID);
				$thebean->setLabel($Bean->LABEL);
				$thebean->setComment($Bean->COMMENT);
				$thebean->setContainer($Bean->IS_CONTAINER);
				$thebean->setMethod($Bean->METHOD);
			}
		}
		catch(Exception $e)     {
			throw $e;
		}

		return $thebean;
	}
	function getByLabel($label){
		try
		{
			$query="select ID from TYPE_PROPERTY where LABEL='".StringHelper::escapeSql($label)."';";
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
	function All(){
		try
		{
			$BeanArray = array();
			$query="select * from TYPE_PROPERTY;";
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