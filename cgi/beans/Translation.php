<?php
/**
 * @package limba.beans
 * @author   Ludovic Reenaers
 * @since 4 nov. 2010
 * @link  http://code.google.com/p/limba
 */

class Translation{
	private $id;
	private $Langue;
	private $label;
	private $word_id;
	function __construct($id) {
		Validator::validateId($id);
		$this->id=$id;
	}
	public function getId(){
		return $this->id;
	}
	function setWordId($id) {
		Validator::validateId($id);
		$this->word_id=$id;
	}
	public function getWordId(){
		return $this->word_id;
	}
	
	public function getLabel(){
		return $this->label;
	}
	public function setLabel($labelstr){
		$this->label = $labelstr;
	}
	
	function getLangue(){
		return $this->langue;
	}
	function setLangue($Langue) {
		if (is_a($Langue,'Langue')){
			$this->langue = $Langue;
		}else{
			trigger_error("ERR_WRONG_KIND_OF_INSTANCE", E_USER_ERROR);
		}
	}
}
?>