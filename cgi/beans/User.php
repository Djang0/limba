<?php
/**
 * @package limba.beans
 * @author   Ludovic Reenaers
 * @since 20 mars 2009
 * @link  http://code.google.com/p/limba
 */
class User{
	private $id;
	private $name;#30
	private $surname;#40
	private $pseudo;#20
	private $email;#255
	private $street;#50
	private $number;#10
	private $zip;#10
	private $city;#50
	private $country;#30
	private $Langue;# obj
	private $ip;#15
	private $ddn;#date
	private $created;#timestamp
	private $last_connected;#timestamp
	private $pws_hash; #32
	private $Groups;
	private $active;#bool
	function __construct($id) {
		Validator::validateId($id);
		$this->id=$id;
	}
	function hasToken($tokenStr){
		$bool = false;
		foreach ($this->Groups as $Profile){
			
			foreach ($Profile->getTokens() as $Token){
				
				if($Token->getLabel()==$tokenStr){
					$bool=true;
				}
			}
		}
		return $bool;
	}
	function belongsToGroupId($id){
		$id=(int)$id;
		$bool=false;
		foreach ($this->Groups as $Profile){
			if((int)$Profile->getId()==$id){
				$bool=true;
			}
		}
		return $bool;
	}
	function setCreated($stamp){
		$this->created = $stamp;
	}
	function setPwsHash($pws,$confirm){

		if ($pws==$confirm){
			Validator::validateHash($pws);
			$this->pws_hash  = $pws;
			
		}else{
			trigger_error("difPws", E_USER_ERROR);
		}
	}
	function belongsToGroupLabel($grpLabel){
		$bool = false;
		foreach ($this->Groups as $Grp){
			if(strtolower($grpLabel) == strtolower($Grp->getLabel())){
				$bool=true;
			}
		}
		return $bool;
	}
	function setGroups($GroupTab){
		if(is_array($GroupTab)){
			$bool = true;
			foreach($GroupTab as $Profile){
				if (!is_a($Profile,'Profile')){
					$bool=false;
				}
			}
			if(!$bool){
				trigger_error("ERR_BAD_LIST_FORMAT", E_USER_ERROR);
			}else{
				$this->Groups = $GroupTab;
			}
		}else{
			trigger_error("ERR_NOT_AN_ARRAY", E_USER_ERROR);
		}
	}
	function setLastConnected($stamp){
		$this->last_connected = $stamp;
	}
	function setDdn($day,$month,$year){
		#ddn_str ex: 1977/01/22
		Validator::validateDate($day,$month,$year);
		$this->ddn=$year."/".$month."/".$day;
		
	}
	function setActive($bool){
		$this->active = $bool;
	}
	function isActive(){
		return $this->active;
	}
	function setIp($ip){
		 
		Validator::validateIp($ip);
		$this->ip=$ip;
		
	}
	function setCountry($country){
		
		if(is_string($country) && (str_replace(" ","",$country) != "")&&strlen($country) > 0 and strlen($country) < 101){
			$this->country = $country;		
			
		}else{
				trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
		}
	}
	function setCity($city){
		if(is_string($city) && str_replace(" ","",$city) != "" && strlen($city) > 0 and strlen($city) < 61){
			
				$this->city  =$city;
		}else{
			trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
		}
	}
	function setZip($zip){
		if(is_string($zip)){

			if(str_replace(" ","",$zip) != ""){
				if(strlen($zip) > 0 and strlen($zip) < 21){
					$this->zip  =$zip;
				}else{
					trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
				}
			}else{
				trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
			}
		}else{
			trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
		}
	}
	function setBoite($boite){
		if(is_string($boite)){

			if(str_replace(" ","",$boite) != ""){
				if(strlen($boite) > 0 and strlen($boite) < 7){
					$this->boite  =$boite;
				}else{
					trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
				}
			}else{
				trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
			}
		}else{
			trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
		}
	}
	function setNumber($number){
		if(is_string($number)){

			if(str_replace(" ","",$number) != ""){
				if(strlen($number) > 0 and strlen($number) < 11){
					$this->number  =$number;
				}else{
					trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
				}
			}else{
				trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
			}
		}else{
			trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
		}
	}
	function setStreet($street){
		if(is_string($street)){

			if(str_replace(" ","",$street) != ""){
				if(strlen($street) > 0 and strlen($street) < 61){
					$this->street  =$street;
				}else{
					trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
				}
			}else{
				trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
			}
		}else{
			trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
		}
	}
	function setEmail($email){
		Validator::validateEmail($email);
		$this->email=$email;
		
	}
	function setPseudo($pseudo){
		if(is_string($pseudo)){
			if(str_replace(" ","",$pseudo) != ""){
				if(strlen($pseudo) > 0 and strlen($pseudo) < 16){
					$this->pseudo  =$pseudo;
				}else{
					trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
				}
			}else{
				trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
			}
		}else{
			trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
		}
	}
	function setSurname($surname){
		if(is_string($surname)){

			if(str_replace(" ","",$surname) != ""){
				if(strlen($surname) > 0 and strlen($surname) < 61){
					$this->surname =$surname;
				}else{
					trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
				}
			}else{
				trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
			}
		}else{
			trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
		}
	}
	function setName($name){
		if(is_string($name)){

			if(str_replace(" ","",$name) != ""){
				if(strlen($name) > 0 and strlen($name) < 61){
					$this->name =$name;
				}else{
					trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
				}
			}else{
				trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
			}
		}else{
			trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
		}
	}
	function setLangue($Langue){

		if(is_a($Langue, "Langue")){
			$this->Langue=$Langue;
		}else{
			trigger_error("ERR_WRONG_KIND_OF_INSTANCE", E_USER_ERROR);
		}
	}
	function getGroups(){
		return $this->Groups;
	}
	function getId(){
		return $this->id;
	}
	function getName(){
		return $this->name;
	}
	function getSurname(){
		return $this->surname;
	}
	function getPseudo(){
		return $this->pseudo;
	}
	function getEmail(){
		return $this->email;
	}
	function getStreet(){
		return $this->street;
	}
	function getNumber(){
		return $this->number;
	}
	function getBoite(){
		return $this->boite;
	}
	function getZip(){
		return $this->zip;
	}
	function getCity(){
		return $this->city;
	}
	function getCountry(){
		return $this->country;
	}
	function getLangue(){
		return $this->Langue;
	}
	function getIp(){
		return $this->ip;
	}
	function getDdn(){
		return $this->ddn;
	}
	function getCreated(){
		return $this->created;
	}
	function getLastConnected(){
		return $this->last_connected;
	}
	function getPwsHash(){
		return $this->pws_hash;
	}
}
?>