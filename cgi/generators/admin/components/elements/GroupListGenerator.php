<?php
/**
 * @package limba.generators.admin.components.elements
 * @author  Ludovic Reenaers
 * @since 12 Fev. 2011
 * @link http://code.google.com/p/limba
 */

class GroupListGenerator extends Generator{
	function setUp(){
		$this->content ="";
		if($_SESSION['USER_BEAN']->belongsToGroupLabel("security")){
			$this->content .= $this->params['translator']->grp.': <select name="{sec}_GroupId" title="'.$this->params['translator']->grpowns.'">'."\n";
			$dao = $this->Factory->getProfileDao();
			$grpTab = $dao->getAll();
			foreach ($grpTab as $Group){
				if($Group->getId() == $this->params['currentAccess']->getGroupId()){
					$sel = "SELECTED";
				}else{
					$sel = "";
				}
				$this->content .= '<option value="'.$Group->getId().'" '.$sel.'>'.$Group->getLabel().'</option>'."\n";
			}
			$this->content .= '</select>'."\n";
		}
		
	}
}
?>