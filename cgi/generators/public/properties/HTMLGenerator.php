<?php
/**
 * @package limba.generators.public.properties
 * @author  Ludovic Reenaers
 * @since 13 janv. 2011
 * @link http://code.google.com/p/limba
 */

class HTMLGenerator extends PropertyGenerator {	
	protected function getShow(){
		$dao = $this->Factory->getPropertyValueDAO();
		$docid = $this->params['currentid'];
		$proId = $this->Property->getId();
		if($this->Property->isNable()){
			$values = $dao->getAllUsingIds($docid,$proId,$_SESSION['langue']);
			$strr = "";
			foreach ($values as $Val){
				$strr .= $Val->getValueText(); 
			}
		}else{
			$value= $dao->getByPropertyByDocumentUsingIds($docid,$proId,$_SESSION['langue']);
			$strr = $value->getValueText();
		}
		return $strr;
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
		//$tmp = '<textarea id="'.$taggedname.'"> </textarea>';
		$strr = <<<EOD
		<tr><td class="labelTD"> $info </td><td><div class="fields" id="$grp">
		<div class="field"><textarea name="$areaname" alt="$tooltip" $cssclass  id="$areaname" title="$tooltip"></textarea>
		<script type="text/javascript">CKEDITOR.replace('$areaname',{toolbar : "MyToolbar"});</script>
		</div>
		
EOD;
		if($this->Property->isNable()){
			$strr .= <<<EOD
			<a class="plus" id="$plusid" href="javascript:void();" onclick="dynadd('$grp','textarea','$taggedname','$cpt','$cssid',function(cssid){CKEDITOR.replace(cssid,{toolbar : 'MyToolbar'});});">+</a>
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
		<div id="$cpt"></div><div class="field"><textarea name="$cssid" alt="$tooltip"  id="$cssid" title="$tooltip">$valtxt</textarea>
		<script type="text/javascript">CKEDITOR.replace("$cssid",{toolbar : "MyToolbar"});</script></div>
EOD;
		}
		if($this->Property->isNable()){
			$strr .= <<<EOD
			<a class="plus" id="$plusid" href="javascript:void();" onclick="dynadd('$grp','textarea','$taggedname','$cpt','$cssid',function(cssid){CKEDITOR.replace(cssid,{toolbar : 'MyToolbar'});});">+</a>
EOD;
		}
		$strr .= '</div></td></tr>';
		return $strr;
	}
}
?>