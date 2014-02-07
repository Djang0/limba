<?php
/**
 * @package limba.generators.public.properties
 * @author  Ludovic Reenaers
 * @since 24 nov. 2010
 * @link http://code.google.com/p/limba
 */
class ChildDocGenerator extends PropertyGenerator{	
	protected function getShow(){
		
		$dao = $this->Factory->getPropertyValueDAO();
		$docid = $this->params['currentid'];
		$proId = $this->Property->getId();
		$value= $dao->getByPropertyByDocumentUsingIds($docid,$proId,$_SESSION['langue']);
		return '<p '.$this->CSS.'>'.$value->getChildDocId().'</p>';
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
		$strr = <<<EOD
		<script type="text/javascript">
	function lookup(inputString) {
	
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions').hide();
		} else {
			$.post("/embed.php?/ajax/auto/", {queryString: ""+inputString+""}, function(data){
				
				if(data.length >0) {
					$('#suggestions').show();
					$('#autoSuggestionsList').html(data);
				}
			});
		}
	} // lookup
	
	function fill(thisValue) {
		$('#inputString').val(thisValue);
		setTimeout("$('#suggestions').hide();", 200);
	}
</script>
<style type="text/css">
	body {
		font-family: Helvetica;
		font-size: 11px;
		color: #000;
	}
	
	h3 {
		margin: 0px;
		padding: 0px;	
	}

	.suggestionsBox {
		position: relative;
		left: 30px;
		margin: 10px 0px 0px 0px;
		width: 200px;
		background-color: #212427;
		-moz-border-radius: 7px;
		-webkit-border-radius: 7px;
		border: 2px solid #000;	
		color: #fff;
	}
	
	.suggestionList {
		margin: 0px;
		padding: 0px;
	}
	
	.suggestionList li {
		
		margin: 0px 0px 3px 0px;
		padding: 3px;
		cursor: pointer;
	}
	
	.suggestionList li:hover {
		background-color: #659CD8;
	}
</style>
<div>
				Type your county:
				<br />
				<input type="text" size="30" value="" id="inputString" onkeyup="lookup(this.value);" />
			</div>
			
			<div class="suggestionsBox" id="suggestions" style="display: none;">
				<img src="/img/limba/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
				<div class="suggestionList" id="autoSuggestionsList">
					&nbsp;
				</div>
			</div>
EOD;
/**		$cssclass = "";
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
		$strr .= '</div></td></tr>';**/
		return $strr;
	}
	public function getEditByIso($iso){
	/**	$dao = $this->Factory->getPropertyValueDAO();
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
		$strr .= '</div></td></tr>';**/
		return $strr;
	}	
}
?>