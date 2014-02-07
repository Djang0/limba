<?php
/**
 * @package limba.generators.public.properties
 * @author  Ludovic Reenaers
 * @since 18 janv. 2011
 * @link http://code.google.com/p/limba
 */

class DateGenerator extends PropertyGenerator{
	protected function getShow(){
		$dao = $this->Factory->getPropertyValueDAO();
		$docid = $this->params['currentid'];
		$proId = $this->Property->getId();
		$value= $dao->getByPropertyByDocumentUsingIds($docid,$proId,$_SESSION['langue']);
		$val = $value->getDateFrom();
		list($year,$month,$day)=preg_split('/[-\.\/ ]/',$val);
		$val = $day."/".$month."/".$year;
		return '<p '.$this->CSS.'>'.$val.'</p>';
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
		$strr ='<tr><td>'.$this->Property->getInfo($iso).' </td><td>';
		$strr .= '<input type="text" name="{str}_'.$this->Property->getId().'_'.$iso.'" title="'.$this->Property->getTooltip($iso).'" alt="'.$this->Property->getTooltip($iso).'" class="w8em format-d-m-y" maxlength="10" id="'.$this->Property->getInfo($iso).$iso.'" READONLY> <a href="#" class="date-picker-control" title="Show Calendar" id="fd-but-'.$this->Property->getInfo($iso).$iso.'"><span>&nbsp;</span></a>';
		$strr .= '</td></tr>';
		return $strr;
	}
	public function getEditByIso($iso){
		$dao = $this->Factory->getPropertyValueDAO();
		$docid = $this->params['currentid'];
		$proId = $this->Property->getId();
		$value= $dao->getByPropertyByDocumentUsingIds($docid,$proId,$iso);
		$val = $value->getDateFrom();
		list($year,$month,$day)=preg_split('/[-\.\/ ]/',$val);
		$val = $day."/".$month."/".$year;
		$strr ='<tr><td>'.$this->Property->getInfo($iso).' </td><td>';
		$strr .= '<input value="'.$val.'" type="text" name="{str}_'.$value->getId().'" title="'.$this->Property->getTooltip($iso).'" alt="'.$this->Property->getTooltip($iso).'" class="w8em format-d-m-y" maxlength="10" id="'.$this->Property->getInfo($iso).$iso.'" READONLY> <a href="#" class="date-picker-control" title="Show Calendar" id="fd-but-'.$this->Property->getInfo($iso).$iso.'"><span>&nbsp;</span></a>';
		$strr .= '</td></tr>';
		return $strr;
	}
}
?>