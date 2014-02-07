<?php
/**
 * @package limba.beans
 * @author   Ludovic Reenaers
 * @since 4 nov. 2009
 * @link  http://code.google.com/p/limba
 */
class LangueLabel{
	private $id;
	private $isoTraduction;
	private $label;
	private $langueId;
	function __construct($id) {
		Validator::validateId($id);
		$this->id=$id;
	}
	public function getId(){
		return $this->id;
	}
	public function setIsoTraduction($iso){
		$this->isoTraduction = $iso;
	}
	public function getlangueId(){
		return $this->langueId;
	}
	public function setlangueId($id){
		Validator::validateId($id);
		$this->langueId=$id;
	}
	public function getIsoTraduction(){
		return $this->isoTraduction;
	}
	public function getLabel(){
		return $this->label;
	}
	public function setLabel($label){
		$this->label = $label;
	}
}
?>