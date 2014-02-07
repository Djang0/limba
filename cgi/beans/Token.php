<?php
/**
 * @package limba.beans
 * @author   Ludovic Reenaers
 * @since 4 nov. 2010
 * @link  http://code.google.com/p/limba
 */
class Token{
	private $id;
	private $label;

	function __construct($id) {
		Validator::validateId($id);
		$this->id=$id;
	}
	public function getId(){
		return $this->id;
	}
	
	public function getLabel(){
		return $this->label;
	}
	public function setLabel($label){
		$this->label = $label;
	}

}
?>