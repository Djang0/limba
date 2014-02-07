<?php
/**
 * @package limba.generators.public.properties
 * @author  Ludovic Reenaers
 * @since 18 janv. 2011
 * @link http://code.google.com/p/limba
 */

class DateIntervalGenerator extends PropertyGenerator{
	protected function getShow(){
		$dao = $this->Factory->getPropertyValueDAO();
		$docid = $this->params['currentid'];
		$proId = $this->Property->getId();
		$value= $dao->getByPropertyByDocumentUsingIds($docid,$proId,$_SESSION['langue']);
		$val = $value->getDateFrom();
		$val2 = $value->getDateTo();
		list($year,$month,$day)=preg_split('/[-\.\/ ]/',$val);
		list($year2,$month2,$day2)=preg_split('/[-\.\/ ]/',$val2);
		$val = $day."/".$month."/".$year;
		$val2 = $day2."/".$month2."/".$year2;
		return '<p '.$this->CSS.'><b>'.$this->params['translator']->dateFrom." : </b>".$val.'<b> '.$this->params['translator']->dateTo.' : </b>'.$val2.'</p>';
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
		$strr .= $this->params['translator']->dateFrom.' : <input type="text" name="{dfr}_'.$this->Property->getId().'_'.$iso.'" title="'.$this->Property->getTooltip($iso).'" alt="'.$this->Property->getTooltip($iso).'" class="w8em format-d-m-y" maxlength="10" id="'.$this->Property->getInfo($iso).$iso.'from" READONLY> <a href="#" class="date-picker-control" title="Show Calendar" id="fd-but-'.$this->Property->getInfo($iso).$iso.'from"><span>&nbsp;</span></a>&nbsp;';
		$strr .= '&nbsp;'.$this->params['translator']->dateTo.' : <input type="text" name="{dto}_'.$this->Property->getId().'_'.$iso.'" title="'.$this->Property->getTooltip($iso).'" alt="'.$this->Property->getTooltip($iso).'" class="w8em format-d-m-y" maxlength="10" id="'.$this->Property->getInfo($iso).$iso.'to" READONLY> <a href="#" class="date-picker-control" title="Show Calendar" id="fd-but-'.$this->Property->getInfo($iso).$iso.'to"><span>&nbsp;</span></a>';
		$strr .= '</td></tr>';
		return $strr;
	}
	public function getEditByIso($iso){
		$dao = $this->Factory->getPropertyValueDAO();
		$docid = $this->params['currentid'];
		$proId = $this->Property->getId();
		$value= $dao->getByPropertyByDocumentUsingIds($docid,$proId,$iso);
		$val = $value->getDateFrom();
		$val2 = $value->getDateTo();
		if(trim($val)<>''){
			list($year,$month,$day)=preg_split('/[-\.\/ ]/',$val);
			$val = $day."/".$month."/".$year;
		}else{
			$val="";
		}
		if(trim($val2)<>''){
			list($year2,$month2,$day2)=preg_split('/[-\.\/ ]/',$val2);
			$val2 = $day2."/".$month2."/".$year2;
		}else{
			$val2="";
		}
		$strr ='<tr><td>'.$this->Property->getInfo($iso).' </td><td>';
		$strr .= $this->params['translator']->dateFrom.' : <input value="'.$val.'" type="text" name="{dfr}_'.$value->getId().'" title="'.$this->Property->getTooltip($iso).'" alt="'.$this->Property->getTooltip($iso).'" class="w8em format-d-m-y" maxlength="10" id="'.$this->Property->getInfo($iso).$iso.'from" READONLY> <a href="#" class="date-picker-control" title="Show Calendar" id="fd-but-'.$this->Property->getInfo($iso).$iso.'from"><span>&nbsp;</span></a>&nbsp';
		$strr .=  $this->params['translator']->dateTo.' : <input value="'.$val2.'" type="text" name="{dto}_'.$value->getId().'" title="'.$this->Property->getTooltip($iso).'" alt="'.$this->Property->getTooltip($iso).'" class="w8em format-d-m-y" maxlength="10" id="'.$this->Property->getInfo($iso).$iso.'to" READONLY> <a href="#" class="date-picker-control" title="Show Calendar" id="fd-but-'.$this->Property->getInfo($iso).$iso.'to"><span>&nbsp;</span></a>';
		$strr .= '</td></tr>';
		return $strr;
	}
}
?>