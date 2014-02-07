<?php
/**
 * @package limba.beans
 * @author   Ludovic Reenaers
 * @since 4 nov. 2010
 * @link  http://code.google.com/p/limba
 */
class Profile{
	private $id;
	private $label;
	private $comment;
	private $tokens;
	private $available;

	function __construct($id) {
		Validator::validateId($id);
		$this->id=$id;
	}
	public function getId(){
		return $this->id;
	}
	public function getAvailable(){
		return $this->available;
	}
	function getLabel(){
		return $this->label;
	}
	function getComment(){
		return $this->comment;
	}
	function getTokens(){
		return $this->tokens;
	}
	function setLabel($label){
		$this->label = $label;
	}
	function setComment($comment){
		$this->comment = $comment;
	}
	function setAvailable($bool){
		if($bool==1 || $bool == 0){
			$this->available = $bool;
		}
	}
	function setTokens($tokenarray){
		if(is_array($tokenarray)){
			$bool = true;
			foreach($tokenarray as $token){
				if (!is_a($token,'Token')){
					$bool=false;
				}
			}
			if(!$bool){
				trigger_error("ERR_BAD_LIST_FORMAT", E_USER_ERROR);
			}else{
				$this->tokens = $tokenarray;
			}
		}else{
			trigger_error("ERR_NOT_AN_ARRAY", E_USER_ERROR);
		}

	}
}
?>