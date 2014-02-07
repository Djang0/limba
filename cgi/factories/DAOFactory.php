<?php
/**
 * @package limba.factories
 * @author  Ludovic Reenaers
 * @since 24 janv. 2009
 * @link http://code.google.com/p/limba
 */


class DAOFactory{
	protected $pdo;
	protected $params;
	protected $CategoryDAO=null;
	protected $CategoryInfoDAO=null;
	protected $DocumentDAO=null;
	protected $DocumentInfoDAO=null;
	protected $GroupDAO = null;
	protected $LangueDAO=null;
	protected $LangueLabelDAO=null;
	protected $ListeDAO=null;
	protected $ListeValueDAO=null;
	protected $ProfileDAO=null;
	protected $PropertyDAO=null;
	protected $PropertyInfoDAO=null;
	protected $PropertyValueDAO=null;
	protected $TokenDAO=null;
	protected $TokenPackDAO=null;
	protected $TranslationDAO=null;
	protected $TypeDocumentDAO=null;
	
	
	protected $TypePropertyDAO=null;
	protected $UserDAO=null;
	protected $WordDAO=null;



	function __construct($params){
		$this->params = $params;
		$user = (string)$this->params['config']->usr;
		$pws = (string)$this->params['config']->pws;
			
		$this->pdo=new PDO((string)$this->params['config']->db,$user,$pws);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$this->pdo->exec('SET CHARACTER SET utf8');

	}
	function getTypePropertyDAO(){
		if($this->TypePropertyDAO==null){

			$this->TypePropertyDAO = new TypePropertyDAO($this->pdo,$this);
		}
		return $this->TypePropertyDAO;
	}
	function getTypeDocumentDAO(){
		if($this->TypeDocumentDAO==null){

			$this->TypeDocumentDAO = new TypeDocumentDAO($this->pdo,$this);
		}
		return $this->TypeDocumentDAO;
	}
	function getGroupDAO(){
		if($this->GroupDAO==null){

			$this->GroupDAO = new GroupDAO($this->pdo,$this);
		}
		return $this->GroupDAO;
	}
	function getUserDAO(){
		if($this->UserDAO==null){

			$this->UserDAO = new UserDAO($this->pdo,$this);
		}
		return $this->UserDAO;
	}
	function getListeDAO(){
		if($this->ListeDAO==null){

			$this->ListeDAO = new ListeDAO($this->pdo,$this);
		}
		return $this->ListeDAO;
	}
	function getListeValueDAO(){
		if($this->ListeValueDAO==null){

			$this->ListeValueDAO = new ListeValueDAO($this->pdo,$this);
		}
		return $this->ListeValueDAO;
	}
	
	function getProfileDAO(){
		if($this->ProfileDAO==null){

			$this->ProfileDAO = new ProfileDAO($this->pdo,$this);
		}
		return $this->ProfileDAO;
	}

	function getPropertyDAO(){
		if($this->PropertyDAO==null){

			$this->PropertyDAO = new PropertyDAO($this->pdo,$this);
		}
		return $this->PropertyDAO;
	}
	function getPropertyInfoDAO(){
		if($this->PropertyInfoDAO==null){

			$this->PropertyInfoDAO = new PropertyInfoDAO($this->pdo,$this);
		}
		return $this->PropertyInfoDAO;
	}
	function getPropertyValueDAO(){
		if($this->PropertyValueDAO==null){

			$this->PropertyValueDAO = new PropertyValueDAO($this->pdo,$this);
		}
		return $this->PropertyValueDAO;
	}
	function getTokenDAO(){
		if($this->TokenDAO==null){

			$this->TokenDAO = new TokenDAO($this->pdo,$this);
		}
		return $this->TokenDAO;
	}
	function getTokenPackDAO(){
		if($this->TokenPackDAO==null){

			$this->TokenPackDAO = new TokenPackDAO($this->pdo,$this);
		}
		return $this->TokenPackDAO;
	}
	function getLangueDAO(){
		if($this->LangueDAO==null){

			$this->LangueDAO = new LangueDAO($this->pdo,$this);
		}
		return $this->LangueDAO;
	}
	function getLangueLabelDAO(){
		if($this->LangueLabelDAO==null){

			$this->LangueLabelDAO = new LangueLabelDAO($this->pdo,$this);
		}
		return $this->LangueLabelDAO;
	}

	function getCategoryDAO(){
		if($this->CategoryDAO==null){

			$this->CategoryDAO = new CategoryDAO($this->pdo,$this);
		}
		return $this->CategoryDAO;
	}
	function getCategoryInfoDAO(){
		if($this->CategoryInfoDAO==null){

			$this->CategoryInfoDAO = new CategoryInfoDAO($this->pdo,$this);
		}
		return $this->CategoryInfoDAO;
	}
	function getDocumentDAO(){
		if($this->DocumentDAO==null){

			$this->DocumentDAO = new DocumentDAO($this->pdo,$this);
		}
		return $this->DocumentDAO;
	}
	function getDocumentInfoDAO(){
		if($this->DocumentInfoDAO==null){

			$this->DocumentInfoDAO = new DocumentInfoDAO($this->pdo,$this);
		}
		return $this->DocumentInfoDAO;
	}
	function getTranslationDAO(){
		if($this->TranslationDAO==null){

			$this->TranslationDAO = new TranslationDAO($this->pdo,$this);
		}
		return $this->TranslationDAO;
	}
	function getWordDAO(){
		if($this->WordDAO==null){

			$this->WordDAO = new WordDAO($this->pdo,$this);
		}
		return $this->WordDAO;
	}
}
?>
