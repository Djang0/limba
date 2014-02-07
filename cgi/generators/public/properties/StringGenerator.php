<?php
/**
 * @package limba.generators.public.properties
 * @author  Ludovic Reenaers
 * @since 24 nov. 2010
 * @link http://code.google.com/p/limba
 */
class StringGenerator extends PropertyGenerator{	
	protected function getShow(){
		
		$dao = $this->Factory->getPropertyValueDAO();
		$docid = $this->params['currentid'];
		$proId = $this->Property->getId();
		$value= $dao->getByPropertyByDocumentUsingIds($docid,$proId,$_SESSION['langue']);
		return '<p '.$this->CSS.'>'.$value->getValueShort().'</p>';
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
		$cssclass = "";
		$cssid= "{str}_".$this->Property->getId().'_'.$iso;
		$grp = $cssid.'grp';
		$cpt = 1;
		if(!is_null($this->Property) && str_replace(' ','',$this->Property->getCssClass())<>""){
			$cssclass .=' class="'.$this->Property->getCssClass().'"';
				
		}
		$plusid = $grp.'plus';
		$info= $this->Property->getInfo($iso);
		$tooltip = $this->Property->getTooltip($iso);
		$areaname = $cssid."_".$cpt;
		$taggedname = $cssid."_{{cpt}}";
		$strr = <<<EOD
		<tr><td class="labelTD"> $info </td><td><div class="fields" id="$grp">
		<div class="field"><input type="text" name="$areaname" alt="$tooltip" $cssclass  id="$areaname" title="$tooltip"/>
		</div>
		
EOD;
		if($this->Property->isNable()){
			$strr .= <<<EOD
			<a class="plus" id="$plusid" href="javascript:void();" onclick="dynadd('$grp','input','$taggedname','$cpt','$cssid',function(cssid){});">+</a>
EOD;
		}
		$strr .= '</div></td></tr>';
		return $strr;
	}
	public function getEditByIso($iso){
		$dao = $this->Factory->getPropertyValueDAO();
		$docid = $this->params['currentid'];
		$proId = $this->Property->getId();
		$values= $dao->getAllUsingIds($docid,$proId,$iso);
		$cpt = 0;
		$info = $this->Property->getInfo($iso);
		$grp = $info.'grp';
		$strr ='<tr><td class="labelTD">'.$info.'</td><td><div class="fields" id="'.$grp.'">';
		foreach ($values as $value){
			$cpt +=1;
			$cssid='{str}_'.$value->getId().'_'.$cpt;
			$taggedname = '{str}_{ins}_'.$proId.'_'.$iso."_{{cpt}}";
			
			$plusid = $grp.'plus';
			
			$valtxt = $value->getValueText();
			$tooltip = $this->Property->getTooltip($iso);
			$strr .= <<<EOD
		<div id="$cpt"></div><div class="field"><input type="text" name="$cssid" alt="$tooltip"  id="$cssid" title="$tooltip">$valtxt</textarea>
EOD;
		}
		if($this->Property->isNable()){
			$strr .= <<<EOD
			<a class="plus" id="$plusid" href="javascript:void();" onclick="dynadd('$grp','input','$taggedname','$cpt','$cssid',function(cssid){});">+</a>
EOD;
		}
		$strr .= '</div></td></tr>';
		return $strr;
	}	
}
?>