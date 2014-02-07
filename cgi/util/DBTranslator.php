<?php
/**
 * @package limba.util
 * @author  Ludovic Reenaers
 * @since 4 nov. 2010
 * @link http://code.google.com/p/limba
 */

class DBTranslator{
	private $daoFactory;
	private $translationDAO;
	public function __construct($daoFactory){
		$this->daoFactory = $daoFactory;
		$this->translationDAO = $this->daoFactory->getTranslationDAO();
	}
	public function getLabel($name){
		$label="NULL!!";
		$translation= $this->translationDAO->getByWordByLangue($_SESSION['langue'],$name);
		if(!is_null($translation)){
			
			$label = $translation->getLabel();
		}
		return $label;
	}
	public function __get($Name)
	{
		return $this->getLabel($Name);
	}
}
?>