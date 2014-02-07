<?php
/**
 * @package limba.beans
 * @author   Ludovic Reenaers
 * @since 4 nov. 2009
 * @link  http://code.google.com/p/limba
 */
class DocumentInfo{
	private $id;
	private $label;
	private $tooltip;
	private $doc_id;
	private $Langue;
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
	function getTooltip(){
		return $this->tooltip;
	}
	function getDocumentId(){
		return $this->doc_id;
	}
	function getLangue(){
		return $this->langue;
	}
	function setLabel($label){
		$this->label = $label;
	}
	function setTooltip($tooltip){
		$this->tooltip = $tooltip;
	}
	function setLangue($Langue) {
		if (is_a($Langue,'Langue')){
			$this->langue = $Langue;
		}else{
			trigger_error("ERR_WRONG_KIND_OF_INSTANCE", E_USER_ERROR);
		}
	}
	function setDocumentId($docId) {
		if (is_int($docId)){
			$this->doc_id = $docId;
		}else{
			trigger_error("ERR_NOT_AN_INTEGER", E_USER_ERROR);
		}
	}
}