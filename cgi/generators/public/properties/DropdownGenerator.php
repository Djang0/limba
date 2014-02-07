<?php
/**
 * @package limba.generators.public.properties
 * @author  Ludovic Reenaers
 * @since 20 avr. 2011
 * @link http://code.google.com/p/limba
 */

class DropdownGenerator extends PropertyGenerator{	
	protected function getShow(){
		$dao = $this->Factory->getPropertyValueDAO();
		$wordDao = $this->Factory->getWordDAO();
		$docid = $this->params['currentid'];
		$proId = $this->Property->getId();
		$value= $dao->getByPropertyByDocumentUsingIds($docid,$proId,$_SESSION['langue']);
		$val = $wordDao->getById($value->getWordId());
		return '<p '.$this->CSS.'>'.$this->Property->getInfo($_SESSION['langue']).' : '.$val->getTranslation($_SESSION['langue'])->getLabel().'</p>';
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
		$strr =  '<tr><td>'.$this->Property->getInfo($iso).' </td><td><select name="{str}_'.$this->Property->getId().'_'.$iso.'" alt="'.$this->Property->getTooltip($iso).'" title="'.$this->Property->getTooltip($iso).'">';
		foreach($this->Property->getListe()->getWords() as $Val){
			$strr .= '<option value="'.$Val->getId().'">'.$Val->getTranslation($_SESSION['langue'])->getLabel().'</option>';
		}
		$strr .= ' </select></td></tr>';
		return $strr;
	}
	public function getEditByIso($iso){
		$dao = $this->Factory->getPropertyValueDAO();
		$docid = $this->params['currentid'];
		$proId = $this->Property->getId();
		$value= $dao->getByPropertyByDocumentUsingIds($docid,$proId,$iso);
		$val = $value->getWordId();
		$strr =  '<tr><td>'.$this->Property->getInfo($iso).' </td><td><select name="{str}_'.$value->getId().'" alt="'.$this->Property->getTooltip($iso).'" title="'.$this->Property->getTooltip($iso).'">';
		foreach($this->Property->getListe()->getWords() as $Val){
			if((int)$Val->getId() == (int)$val){
				$strr .= '<option SELECTED value="'.$Val->getId().'">'.$Val->getTranslation($_SESSION['langue'])->getLabel().'</option>';
			}else{
				$strr .= '<option value="'.$Val->getId().'">'.$Val->getTranslation($_SESSION['langue'])->getLabel().'</option>';
			}
		}
		$strr .= ' </select></td></tr>';
		return $strr;
	}
}
?>