<?php
/**
 * @package limba.generators.public.components.elements
 * @author  Ludovic Reenaers
 * @since 21 oct. 2010
 * @link http://code.google.com/p/limba
 */
class UserPadGenerator extends Generator{
	function setup(){
		$this->content = '<div id="gaia">';
		if($_SESSION["USER_BEAN"]->getName() == "anonymous"){
			$this->content.='<span><a href="'.$_SERVER['SCRIPT_NAME'].'?/login/show/">'.$this->params['translator']->login.'</a></span> | <span><a href="'.$_SERVER['SCRIPT_NAME'].'?/user/add/">'.$this->params['translator']->register.'</a></span>';
		}else{
			$this->content.='<b>'.strtolower($_SESSION['USER_BEAN']->getEmail()).'</b> |';
			$this->content .= '<span><a href="'.$_SERVER['SCRIPT_NAME'].'?/user/edit/">'.$this->params['translator']->prefs.'</a></span> | <span><a href="'.$_SERVER['SCRIPT_NAME'].'?/user/logout/">'.$this->params['translator']->logout.'</a></span>';
		}
		$this->content .='</div>';
	}
}
?>