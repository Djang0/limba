<?php
/**
 * @package limba.models
 * @author  Ludovic Reenaers
 * @since 30 sept. 2010
 * @link http://code.google.com/p/limba
 */

class ModelLanguage extends Model{
	function change(){
		$dao= $this->factory->getLangueDAO();
		$lngBean = $dao->getByIso($this->params["iso"]);
		$_SESSION["langue"] = $lngBean->getIso();
		if($_SESSION['USER_BEAN']->getName()<>"anonymous"){
			$_SESSION['USER_BEAN']->setLangue($lngBean);
			$usrdao= $this->factory->getUserDAO();
			$usrdao->update($_SESSION['USER_BEAN']);
		}
		setcookie((string)$this->params['config']->sitename.'[langue]', $this->params["iso"]);
		if (count($this->params)>=5){
			$retUrl = $_SERVER['SCRIPT_NAME']."?".str_replace("{{-}","/",$this->params["returl"]);
		}else{
			$retUrl = $_SERVER['SCRIPT_NAME']."?/homepage/show/";
		}
		return $retUrl;
	}
}
?>
