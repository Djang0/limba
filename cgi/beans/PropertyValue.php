<?php
/**
 * @package limba.beans
 * @author   Ludovic Reenaers
 * @since 4 nov. 2010
 * @link  http://code.google.com/p/limba
 */
class PropertyValue{
	
	private $id;
	private $PropertyId;
	private $Langue;
	private $DocumentId;
	private $valueShort;
	private $valueText;
	private $word_id;
	private $dateFrom;
	private $dateTo;
	private $duration;
	private $checked;
	private $ChildDocId;
	
	function __construct($id) {
		Validator::validateId($id);
		$this->id=$id;
	}
	function getId(){
		return $this->id;
	}
	function setCaptcha(){
		return true;
	}
	function getChildDocId(){
		return $this->ChildDocId;
	}
	function setChildDocId($id){
		try {
			$id = (int)$id;
			if($id >= 0){
				$this->ChildDocId=$id;
			}else{
				trigger_error("ERR_WRONG_VALUE", E_USER_ERROR);
			}
		}catch(Exception $e){
			trigger_error("ERR_NOT_AN_INTEGER", E_USER_ERROR);
		}
	}
	
	function getPropertyId(){
		return $this->PropertyId;
	}
	function setPropertyId($id){
		if (is_int($id)){
			if($id >= 0){
				$this->PropertyId=$id;
			}else{
				trigger_error("ERR_WRONG_VALUE", E_USER_ERROR);
			}
		}else{
			trigger_error("ERR_NOT_AN_INTEGER", E_USER_ERROR);
		}
	}
	function getLangue(){
		return $this->Langue;
	}
	function setLangue($Langue){
		if (is_a($Langue, "Langue")){
			$this->Langue = $Langue;
		}else{
			trigger_error("ERR_WRONG_KIND_OF_INSTANCE", E_USER_ERROR);
		}
	}
	function getDocumentId(){
		return $this->DocumentId;
	}
	function setDocumentId($id){
		if (is_int($id)){
			if($id >= 0){
				$this->DocumentId=$id;
			}else{
				trigger_error("ERR_WRONG_VALUE", E_USER_ERROR);
			}
		}else{
			trigger_error("ERR_NOT_AN_INTEGER", E_USER_ERROR);
		}
	}
	function getValueShort(){
		return $this->valueShort;
	}
	function setValueShort($val){
		$this->valueShort = $val;
	}
	function getValueText(){
		return $this->valueText;
	}
	function getValueHTML(){
		return $this->valueText;
	}
	function setValueText($val){
		$this->valueText = StringHelper::escapeSql($val);
	}
	function setValueTextFromDB($val){
		$this->valueText = $val;
	}
	function setValueHTML($val){
		$this->valueText = StringHelper::escapeSql($val,true);
	}
	function getWordId(){
		return $this->word_id;
	}
	function setWordId($wordId){
		Validator::validateId($wordId);
		$this->word_id = $wordId;
	}
	function getDateFrom(){
		return $this->dateFrom;
	}
	function setDateFrom($datestr,$format="DMY"){
		if(strtoupper($format) == "DMY"){
			list($day,$month,$year)=preg_split('/[-\.\/ ]/',$datestr);
		}elseif (strtoupper($format) == "YMD"){
			list($year,$month,$day)=preg_split('/[-\.\/ ]/',$datestr);
		}
		Validator::validateDate($day,$month,$year);
		$this->dateFrom=$year."/".$month."/".$day;
		
	}
	function setInterval($tab){
		
		if(isset($tab[0]) && trim($tab[0])<>''){
			list($day,$month,$year)=preg_split('/[-\.\/ ]/',$tab[0]);
			$this->dateFrom=$year."/".$month."/".$day;
		}else{
			$this->dateFrom ="";
		}
		if(isset($tab[1]) && trim($tab[1])<>''){
			list($day2,$month2,$year2)=preg_split('/[-\.\/ ]/',$tab[1]);
			$this->dateTo=$year2."/".$month2."/".$day2;
		}else{
			if(isset($tab[0]) && trim($tab[0])<>''){
				$this->dateTo = $this->dateFrom;
			}else{
				$this->dateTo = "";
			}
		}
		
		
		
	}
	function getDateTo(){
		return $this->dateTo;
	}
	function setDateTo($datestr,$format="DMY"){
		//$mysqldate = date( 'Y-m-d H:i:s', $phpdate );
		//$phpdate = strtotime( $mysqldate );
		if(strtoupper($format) == "DMY"){
			list($day,$month,$year)=preg_split('/[-\.\/ ]/',$datestr);
		}elseif (strtoupper($format) == "YMD"){
			list($year,$month,$day)=preg_split('/[-\.\/ ]/',$datestr);
		}
		Validator::validateDate($day,$month,$year);
		$this->dateTo=$year."/".$month."/".$day;
		
	}
	function getDuration(){
		return $this->duration;
	}
	function setDuration($duration){
		$this->duration = $duration;
	}
	function getChecked(){
		return $this->checked;
	}
	function setChecked($checkBool){

		$this->checked = $checkBool;
		
	}
}
?>