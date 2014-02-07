<?php
/**
 * @package limba.util
 * @author  Ludovic Reenaers
 * @since 15 déc. 2010
 * @link http://code.google.com/p/limba
 */

class SecurityManager{
	private $params;
	private $AM;
	private $function;
	private $access;
	private $status;
	public function __construct($params){
		$this->params =$params;
		$this->function = false;
		$this->access = false;
		$this->status = 1;
		$this->AM = new AuthorizationManager($this->params);
		if($_SESSION["USER_BEAN"]->hasToken($this->params["module"]."#".$this->params["action"])){
			if($this->params["module"]=="document" || $this->params["module"]=="category"){
				$this->access= $this->authorizeRequest($this->params["currentAccess"]->getPermission());
				if(!$this->access){
					$this->status = 0;
					trigger_error("ERR_LACK_OF_PRIVILEGE", E_USER_ERROR);
				}
			}
		}else{
			$this->status = 0;
			trigger_error("ERR_LACK_OF_PRIVILEGE", E_USER_ERROR);
		}
	}
	public function authorizeRequest($permBin){
		return $this->AM->authorizeRequest($permBin);
	}
	function authorizeAccessToObject($permissionableObject,$accessType){
		return $this->AM->authorizeAccessToObject($permissionableObject, $accessType);
	}
	public function getStatus(){
		return $this->status;
	}
}
?>