<?php
/**
 * @package limba.beans
 * @author   Ludovic Reenaers
 * @since 4 nov. 2009
 * @link  http://code.google.com/p/limba
 */
class Langue{
	private $id;
	private $iso;
	private $ordered;
	private $labels;
	private $is_default;
	private $available;
	function __construct($id) {
		Validator::validateId($id);
		$this->id=$id;
	}
	public function isAvailable(){
		return $this->available;
	}
	public function setAvailable($bool){
		if($bool==1 || $bool == 0){
			$this->available = $bool;
		}
	}
	public function isDefault(){
		return $this->is_default;
	}
	public function setDefault($bool){
		if($bool==1 || $bool == 0){
			$this->is_default = $bool;
		}
	}
	public function getId(){
		return $this->id;
	}

	public function setLabels($labelTab){
		if (is_array($labelTab)){
			$this->labels = $labelTab;
		}
	}
	public function getLabels(){
		return $this->labels;
	}
	public function getLabel($lang){
		$labelStr ="";
		foreach ($this->getLabels() as $Label) {
			if($Label->getIsoTraduction() == $lang){
				$labelStr = $Label->getLabel();
			}
				
		}
		return $labelStr;
	}
	public function setOrderedPosition($orderPos){
		$this->ordered = $orderPos;
	}
	public function getOrderedPosition(){
		return $this->ordered;
	}
	public function setIso( $iso){
		$this->iso = $iso;
	}
	public function getIso(){
		return $this->iso;
	}
}
?>