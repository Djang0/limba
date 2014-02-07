<?php
/**
 * @package limba.generators.admin.components.elements
 * @author  Ludovic Reenaers
 * @since 12 Fev. 2011
 * @link http://code.google.com/p/limba
 */

class UserListGenerator extends Generator{
	function setUp(){
		$this->content ="";
		if($_SESSION['USER_BEAN']->belongsToGroupLabel("security")){
			$this->content .= $this->params['translator']->usr.': <select name="{sec}_OwnerId" title="'.$this->params['translator']->owner.'">'."\n";
			$dao = $this->Factory->getUserDao();
			$usrTab = $dao->getAll();
			foreach ($usrTab as $User){
				if($User->getId() == $_SESSION['USER_BEAN']->getId()){
					$sel = "SELECTED";
				}else{
					$sel = "";
				}
				$this->content .= '<option value="'.$User->getId().'" '.$sel.'>'.$User->getName().', '.$User->getSurname().'</option>'."\n";
			}
			$this->content .= '</select>'."\n";
		}
		
	}
}
?>