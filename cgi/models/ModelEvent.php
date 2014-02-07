<?php
/**
 * @package limba.models
 * @author  Ludovic Reenaers
 * @since 17 mar. 2011
 * @link http://code.google.com/p/limba
 */

class ModelEvent extends Model{
	function browse(){
		$typeDAO = $this->factory->getTypeDocumentDAO();
		$docDAO = $this->factory->getDocumentDAO();
		$typPropDAO = $this->factory->getTypePropertyDAO();
		$Type = $typeDAO->getByLabel('Event');
		$docs = $docDAO->getAllByTypeDocument($Type);
		$typProp = $typPropDAO->getByLabel('DateInterval');
		$str="";
		$str .='<table cellspacing="0" cellpadding="0" border="0" class="display" id="dynTab"> ';
		$str .='<thead><tr><th>De<span>&nbsp;&nbsp;&nbsp;</span></th>';
		$str .='<th>A<span>&nbsp;&nbsp;&nbsp;</span></th>';
		$str .='<th>Evénement<span>&nbsp;&nbsp;&nbsp;</span></th>';
		$str .='</tr></thead>';
		$str .='<tbody>';
		foreach ($docs as $Doc){
			$interv =$Doc->getProperty($typProp);
			$str .='<tr>';
			$str .='<td><a href="'.$_SERVER['SCRIPT_NAME'].'?/document/show/'.$Doc->getId().'/" title="'.$Doc->getTooltip($_SESSION['langue']).'">'.$interv->getDateFrom().'</a></td>';
			$str .='<td><a href="'.$_SERVER['SCRIPT_NAME'].'?/document/show/'.$Doc->getId().'/" title="'.$Doc->getTooltip($_SESSION['langue']).'">'.$interv->getDateTo().'</a>	</td>';
			$str .='<td><a href="'.$_SERVER['SCRIPT_NAME'].'?/document/show/'.$Doc->getId().'/" title="'.$Doc->getTooltip($_SESSION['langue']).'">'.$Doc->getLabel($_SESSION['langue']).'</a></td>';
			$str .='</tr>';
		}
		$str .='</tr></tbody>';
		$str .='</table>';
		return $str;
	}
}
?>