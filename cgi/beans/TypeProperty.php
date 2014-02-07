<?php
/**
 * @package limba.beans
 * @author   Ludovic Reenaers
 * @since 20 mars 2009
 * @link  http://code.google.com/p/limba
 */
class TypeProperty{
	private $id;
	private $label;
	private $comment;
	private $isContainer;
	private $method;
	function __construct($id) {
		Validator::validateId($id);
		$this->id=$id;
	}
	public function getMethod(){
		return $this->method;
	}
	public function setMethod($methStr){
		$this->method = $methStr;
	}
	public function getId(){
		return $this->id;
	}
	public function setLabel($label){

		$this->label = $label;

	}
	public function getLabel(){
		return $this->label;
	}
	public function setComment($comment){

		$this->comment = $comment;

	}
	public function getComment(){
		return $this->comment;
	}
	public function setContainer($bool){
		if($bool==1 || $bool == 0){
			$this->isContainer = $bool;
		}else{
			trigger_error("ERR_NOT_A_BOOLEAN", E_USER_ERROR);
		}
	}
}
?>