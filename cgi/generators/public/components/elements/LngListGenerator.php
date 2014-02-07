<?php
/**
 * @package limba.generators.public.components.elements
 * @author  Ludovic Reenaers
 * @since 9 nov. 2010
 * @link http://code.google.com/p/limba
 */

class LngListGenerator extends Generator{
	function setUp(){
		$dao = $this->Factory->getLangueDAO();
		$lngtab = $dao->getAllAvailable();
		$this->content = '<select name="lng" title="'.$this->params['translator']->lngInfo.'" alt="'.$this->params['translator']->lngInfo.'">';

		foreach ($lngtab as $Langue) {
			if($Langue->getIso() == $_SESSION['USER_BEAN']->getLangue()->getIso()){
				$this->content .= '<option value="'.$Langue->getId().'" SELECTED>'.$Langue->getLabel($_SESSION['langue']).'</option>';
			}else{
				$this->content .= '<option value="'.$Langue->getId().'">'.$Langue->getLabel($_SESSION['langue']).'</option>';
			}
		}
		$this->content .= "</select>";
	}
}
?>