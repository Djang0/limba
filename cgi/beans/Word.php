<?php
/**
 * @package limba.beans
 * @author   Ludovic Reenaers
 * @since 22 fev. 2011
 * @link  http://code.google.com/p/limba
 */

class Word{
	private $id;
	private $label;
	private $translations;
	private $listId;
	function __construct($id) {
		Validator::validateId($id);
		$this->id=$id;
	}
	function setListeId($id){
		Validator::validateId($id);
		$this->listId=$id;
	}
	function getListeId(){
		return $this->listId;
	}
	public function getId(){
		return $this->id;
	}
	public function getTranslations(){
		return $this->translations;
	}
	public function getTranslation($iso){
		$tr = null;
		if(!is_null($this->getTranslations())){
			foreach ($this->getTranslations() as $trans){
				if($trans->getLangue()->getIso() == $iso){
					$tr = $trans;
				}
			}
		}
		return $tr;
	}
	public function setTranslations($transTab){
		if(is_array($transTab)){
			$bool = true;
			foreach ($transTab as $trans){
				if  (!is_a($trans, 'Translation')){
					$bool=false;
				}
			}
			if (!$bool){
				trigger_error("ERR_BAD_LIST_FORMAT", E_USER_ERROR);
			}else{
				$this->translations=$transTab;
			}
		}else{
			trigger_error("ERR_NOT_AN_ARRAY", E_USER_ERROR);
		}
	}
	public function getLabel(){
		return $this->label;
	}
	public function setLabel($labelstr){
		$this->label = $labelstr;
	}
}
?>