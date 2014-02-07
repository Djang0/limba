<?php
/**
 * @package limba.generators.admin.components.elements
 * @author  Ludovic Reenaers
 * @since 12 Fev. 2011
 * @link http://code.google.com/p/limba
 */

class SecuritySetGenerator extends Generator{
	function setUp(){
		$this->content ="";
		if($_SESSION['USER_BEAN']->belongsToGroupLabel("security")){
			$this->content .='<fieldset><legend>Security</legend>'."\n";
			$ow = new UserListGenerator($this->params, $this->Factory);
			$grp = new GroupListGenerator( $this->params, $this->Factory);
			$perm = new PermissionGenerator($this->params, $this->Factory);
			$this->content .= $ow->dump();
			$this->content .= $grp->dump();
			$this->content .= $this->params['translator']->isVisible.' <select name="{sec}_Visible" id="{sec}_Visible" title="'.$this->params['translator']->visibleBool.'">'."\n";
			if($this->params['currentAccess']->isVisible()){
				$this->content.='<option value="0">0</option><option value="1" SELECTED>1</option>'."\n";
			}else{
				$this->content.='<option value="0" SELECTED>0</option><option value="1">1</option>'."\n";
			}
			$this->content.='</select>'."\n";
			if($this->params['action']=='add'){
				$this->content .= $this->params['translator']->alternate.': <input type="text" name="{sec}_alternate" id="{sec}_alternate" value="" title="'.$this->params['translator']->longAlt.'"/>'."\n";
			}else{
				$this->content .= $this->params['translator']->alternate.': <input type="text" name="{sec}_alternate" id="{sec}_alternate" value="'.$this->params['currentAccess']->getAlternate().'" title="'.$this->params['translator']->longAlt.'"/>'."\n";
			}
			$this->content .= $perm->dump();
			$this->content .= '</fieldset>'."\n";
		}
		
	}
}
?>