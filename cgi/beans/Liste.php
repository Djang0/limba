<?php
/**
 * @package limba.beans
 * @author   Ludovic Reenaers
 * @since 4 nov. 2010
 * @link  http://code.google.com/p/limba
 */
class Liste{
	private $id;
	private $label;
	private $values;
	function __construct($id) {
		Validator::validateId($id);
		$this->id=$id;
	}
	function getId(){
		return $this->id;
	}
	function getLabel(){
		return $this->label;
	}
	function getWords(){
		return $this->words;
	}
	function setLabel($label){
		$this->label = $label;
	}
	function setWords($wordsTab){
		Validator::validateWordTab($wordsTab);
		$this->words=$wordsTab;
	}
}
?>