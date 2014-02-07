<?php
/**
 * @package limba.util
 * @author  Ludovic Reenaers
 * @since 15 déc. 2010
 * @link http://code.google.com/p/limba
 */

class AuthorizationManager{
	private $R = "1000";
	private $A = "0100";
	private $U = "0010";
	private $D = "0001";
	
	private $accessLvl;//OWNER , GROUP, OTHER
	private $accessType;//R (read),A (add),U (update),D (delete)
	private $params;
	
	public function __construct($params){
		$this->params = $params;
		if(!is_null($this->params["currentAccess"])){
			$this->defineAccessLvl();
			$this->defineAccessType();
		}
	}
	private function defineAccessType(){
		
		if($this->params["action"] == 'show' || $this->params["action"] == 'list' || $this->params["action"] == 'admin'){
			$this->setAccessType("R");
		}elseif ($this->params["action"]=='edit' || $this->params["action"]=='update' || $this->params["action"]=='reset' || $this->params["action"]=='remind'){
			$this->setAccessType("U");
		}elseif ($this->params["action"]=='add' || $this->params["action"]=='insert'){
			$this->setAccessType("A");
		}elseif ($this->params["action"]=='delete' || $this->params["action"]=='remove'){
			$this->setAccessType("D");
		}
	}	
	private function defineAccessLvl(){
		if((int)$_SESSION["USER_BEAN"]->getId() == (int)$this->params["currentAccess"]->getOwnerId()){
			$this->setAccessLvl("OWNER");
		}elseif ($_SESSION["USER_BEAN"]->belongsToGroupId($this->params["currentAccess"]->getGroupId())){
			$this->setAccessLvl("GROUP");
		}else{
			$this->setAccessLvl("OTHER");
		}
	}
	private function setAccessType($accessType){
		if(strtolower($accessType)=='r' || strtolower($accessType)=='a' || strtolower($accessType)=='u' || strtolower($accessType)=='d'){
			$this->accessType = strtoupper($accessType);
		}
	}
	private function setAccessLvl($accessLvl){
		if (strtolower($accessLvl)=='owner' || strtolower($accessLvl)=='group' || strtolower($accessLvl)=='other'){
			$this->accessLvl = $accessLvl;
		}
	}
	private function getAccessLvl(){
		return $this->accessLvl;
	}
	private function getAccessType(){
		return $this->accessType;
	}
	private function authorizeAcces($accessTypeBinary, $objectPermission){
		
		$perm = (binary)$accessTypeBinary;
		$value = (binary)$objectPermission;
		$assertion = $value &= $perm;
		$bool = false;
		if($assertion == $perm){
			$bool = true;
		}
		return $bool;
	}
	public function authorizeRequest($binary){
		
		if(!is_null($this->params["currentAccess"])){
			$type = $this->accessType;
			
			if($this->getAccessLvl() == "OWNER"){
			
				$binary = substr($binary, 0,4);
			}elseif ($this->getAccessLvl() == "GROUP"){
				
				$binary = substr($binary, 4,4);
			}elseif ($this->getAccessLvl() == "OTHER"){
				
				$binary = substr($binary, 8,4);
			}
			$ret=$this->authorizeAcces($this->$type, $binary);
			
		}else{
			$ret =null;
		}
		return $ret;
	}
	function authorizeAccessToObject($permissionableObject,$accessType){
		if((int)$_SESSION["USER_BEAN"]->getId() == (int)$permissionableObject->getOwnerId()){
			$binary = substr($permissionableObject->getPermission(), 0,4);
		}elseif ($_SESSION["USER_BEAN"]->belongsToGroupId($permissionableObject->getGroupId())){
			$binary = substr($permissionableObject->getPermission(), 4,4);
		}else{
			$binary = substr($permissionableObject->getPermission(), 8,4);
		}
		$type=strtoupper($accessType);
		return $this->authorizeAcces($this->$type, $binary);
	}
}
?>