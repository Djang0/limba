<?php
/**
 * @package limba.util
 * @author  Ludovic Reenaers
 * @since 08 avr. 2011
 * @link http://code.google.com/p/limba
 */
class ParamBuilder{
	private $params;
	private $urltab;
	function __construct(){
		$this->params =array();
		$this->urltab = explode("/",substr($_SERVER["REQUEST_URI"],strlen($_SERVER["SCRIPT_NAME"])+1));
		$xmlfile = PathFactory::getConfigPath().'server.xml';
		$this->params['config'] = simplexml_load_file($xmlfile);
		try{
			if(count($this->urltab)<=1){
				$this->handleNoParamRequest();
			}else{
				$this->handleRequest();
				
			}
		}catch(Exception $e){
			trigger_error("ERR_MALFORMED_URL", E_USER_ERROR);
		}
	}
	public function getParams(){
		return $this->params;
	}
	private function handleNoParamRequest(){
		if($_SERVER["SCRIPT_NAME"] == "/admin.php"){
			$this->params["action"] = "admin";
			$this->params["module"] = "homepage" ;
			$this->params["currentid"]= (int)$this->params['config']->rootCatId;
		}else{
			$this->params["action"] = "show";
			$this->params["module"] = "homepage";
			$this->params["currentid"]= (int)$this->params['config']->HomepageId;
		}
	}
	private function parseUrlForDocument(){
		if($this->params["action"]=="add"){
			$this->params["currentid"]= 0	;
			$this->params["typeid"] = $this->urltab[4];
			$this->params["targetcatid"] = $this->urltab[3];
		}elseif ($this->params["action"]=="edit"){
			$this->params["currentid"] = $this->urltab[3];
		}elseif ($this->params["action"]=="show"){
			$this->params["currentid"] = $this->urltab[3];
		}elseif ($this->params["action"]=="admin"){
			$this->params["currentid"] = $this->urltab[3];
		}elseif ($this->params["action"]=="insert"){
			$this->params["currentid"] = $_POST['targetcatid'];
			$this->params["typeid"] = $_POST['typedocid'];
		}elseif ($this->params["action"]=="update"){
			$this->params["currentid"]=$_POST['currentid'];
		}else{
			trigger_error("ERR_UNKNOWN_ACTION", E_USER_ERROR);
		}
	}
	private function parseUrlForCategory(){
		if($this->params["action"]=="add"){
			$this->params["currentid"] = $this->urltab[3];
			$this->params["targetcatid"] = $this->urltab[3];
		}elseif ($this->params["action"]=="edit"){
			$this->params["currentid"] = $this->urltab[3];
		}elseif ($this->params["action"]=="show"){
			$this->params["currentid"] = $this->urltab[3];
		}elseif ($this->params["action"]=="admin"){
			$this->params["currentid"] = $this->urltab[3];
		}elseif ($this->params["action"]=="insert"){
			$this->params["currentid"] = $_POST['targetcatid'];
			$this->params["targetcatid"] = $_POST['targetcatid'];
		}elseif ($this->params["action"]=="update"){
			$this->params["currentid"]=$_POST['currentid'];
		}else{
			trigger_error("ERR_UNKNOWN_ACTION", E_USER_ERROR);
		}
	}
	private function parseUrlForUser(){
		if($this->params["action"]=="reset"){
			$this->params["candidate"] = $this->urltab[4];
			$this->params["mail"] = $this->urltab[3];
			$this->params["currentid"]= 0 ;
		}else{
			$this->params["currentid"]= 0 ;
		}
	}
	private function parseUrlForAjax(){
		// emebed.php?/ajax/tree/callerModule/callerAction/callerTargetId/callerCtx
		if($this->params["action"]=="tree"){
			$this->params["callerid"]= $this->urltab[5];
			$this->params["calleraction"]= $this->urltab[4];
			$this->params["callermodule"]= $this->urltab[3];
			$this->params["callerctx"]= $this->urltab[6];
			$this->params["currentid"]= 0 ;
		}else{
			$this->params["currentid"]= 0 ;
		}
	}
	private function parseUrlForLangs(){
		if($this->params["action"]=="edit"){
			$this->params["currentid"]= $this->urltab[3];
		}else{
			$this->params["currentid"]= 0 ;
		}
	}
	private function parseUrlForAdmin(){
		if($this->params["action"]=="useredit"){
			$this->params["currentid"]= 0 ;
			if(isset($this->urltab[3]) && trim($this->urltab[3])<>''){
				$this->params["targetusrid"] = $this->urltab[3];
			}
		}
	}
	private function parseUrlForProfile(){
		if($this->params["action"]=="edit"){
			$this->params["currentid"]= 0 ;
			if(isset($this->urltab[3]) && trim($this->urltab[3])<>''){
				$this->params["profid"] = $this->urltab[3];
			}
		}elseif ($this->params["action"]=="add" ||$this->params["action"]=="insert"){
			$this->params["currentid"]= 0 ;
		}
	}
	private function parseUrlForLanguage(){
		if($this->params["action"]=="change"){
			$this->params["currentid"]= 0 ;
			$this->params["iso"] = $this->urltab[3];
			$this->params["returl"] = $this->urltab[4];
		}else{
			$this->params["currentid"]= 0 ;
		}		
	}
	private function parseUrlForHomePage(){
		if($this->params["action"]=="admin"){
			$this->params["currentid"]= (int)$this->params['config']->rootCatId;
		}elseif ($this->params["action"]=="show"){
			if($_SERVER['SCRIPT_NAME']== '/admin.php'){
				$this->params["currentid"]= (int)$this->params['config']->rootCatId;
				$this->params["action"] = "admin";
			}else{
				$this->params["currentid"]= (int)$this->params['config']->HomepageId;
			}
		}else{
			$this->params["currentid"]= 0 ;
		}
	}
	private function parseUrlForContact(){
		if($this->params["action"]=="add"){
			$this->params['typelabel']='contact';
			$this->params["currentid"]= 0;
			$this->params["targetcatid"]= (int)$this->params['config']->contactCatId;
		}elseif($this->params["action"]=="insert"){
			$this->params["currentid"] = $_POST['targetcatid'];
			$this->params["typeid"] = $_POST['typedocid'];
		}elseif($this->params["action"]=="done"){
			$this->params["currentid"]= 0;
		}		
	}
	private function parseUrlForTokens(){
		if($this->params["action"]=="add"){
			$this->params["currentid"] = 0;
		}elseif($this->params["action"]=="edit"){
			$this->params["currentid"] = 0;
			if(isset($this->urltab[3]) && trim($this->urltab[3])<>''){
				$this->params["targettkid"] = $this->urltab[3];
			}
		}elseif($this->params["action"]=="update"){
			$this->params["currentid"] = 0;
			$this->params["targettkid"] = $_POST['currentid'];
		}else{
			$this->params["currentid"]= 0;
		}
	}
	private function handleRequest(){
		$this->params["action"] = strtolower($this->urltab[2]);
		$this->params["module"] = strtolower($this->urltab[1]);
		
		if($this->params["module"]=="document"){
			$this->parseUrlForDocument();
		}elseif ($this->params["module"]=="category"){
			$this->parseUrlForCategory();
		}elseif ($this->params["module"]=="user"){
			$this->parseUrlForUser();
		}elseif ($this->params["module"]=="admin"){
			$this->parseUrlForAdmin();
		}elseif ($this->params["module"]=="language"){
			$this->parseUrlForLanguage();
		}elseif ($this->params["module"]=="homepage"){
			$this->parseUrlForHomePage();
		}elseif($this->params["module"]=="contact"){
			$this->parseUrlForContact();
		}elseif($this->params["module"]=="tokens"){
			$this->parseUrlForTokens();
		}elseif ($this->params["module"]=="profile"){
			$this->parseUrlForProfile();
		}elseif ($this->params["module"]=="langs"){
			$this->parseUrlForLangs();
		}elseif ($this->params["module"]=="ajax"){
			$this->parseUrlForAjax();
		}else{
			$this->params["currentid"]= 0 ;
		}
	}
}


?>