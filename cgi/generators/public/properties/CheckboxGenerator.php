<?php
/**
 * @package limba.generators.public.properties
 * @author  Ludovic Reenaers
 * @since 13 janv. 2011
 * @link http://code.google.com/p/limba
 */

class CheckboxGenerator extends PropertyGenerator{	
	protected function getShow(){
		$dao = $this->Factory->getPropertyValueDAO();
		$docid = $this->params['currentid'];
		$proId = $this->Property->getId();
		$value= $dao->getByPropertyByDocumentUsingIds($docid,$proId,$_SESSION['langue']);
		$val = $value->getChecked();
		if($val){
			$filesrc = '/img/internals/checked.png';
		}else{
			$filesrc = '/img/internals/not_checked.png';
		}
		return '<p '.$this->CSS.'>'.$this->Property->getInfo($_SESSION['langue']).' : <img src = "'.$filesrc.'"/></p>';
	}
	protected function getAdd(){
		$this->handleValidation();
		return $this->getAddByIso($_SESSION['langue']);
	}
	protected function getEdit(){
		$this->handleValidation();
		return $this->getEditByIso($_SESSION['langue']);
	}
	protected function getAdmin(){
		return $this->getShow();
	}
	public function getAddByIso($iso){
		$hiddenexpect = '<input type="hidden" name="{xpe}_'.$this->Property->getId().'_'.$iso.'"/>';
		return '<tr><td>'.$this->Property->getInfo($iso).' </td><td>'.$hiddenexpect.'<input type="checkbox" name="{chk}_'.$this->Property->getId().'_'.$iso.'" alt="'.$this->Property->getTooltip($iso).'" title="'.$this->Property->getTooltip($iso).'" /></td></tr>';
	}
	public function getEditByIso($iso){
		$dao = $this->Factory->getPropertyValueDAO();
		$docid = $this->params['currentid'];
		$proId = $this->Property->getId();
		$value= $dao->getByPropertyByDocumentUsingIds($docid,$proId,$iso);
		$val = $value->getChecked();
		
		$chk ="";
		if($val){
			$chk="checked";
		}
		$hiddenexpect = '<input type="hidden" name="{xpe}_'.$value->getId().'"/>';
		return '<tr><td>'.$this->Property->getInfo($iso).' </td><td>'.$hiddenexpect.'<input type="checkbox" name="{chk}_'.$value->getId().'" alt="'.$this->Property->getTooltip($iso).'" title="'.$this->Property->getTooltip($iso).'" '.$chk.'/></td></tr>';
	}
}
?>