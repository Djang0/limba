<?php
/**
 * @package limba.generators.admin.components.elements
 * @author  Ludovic Reenaers
 * @since on 12 Fev. 2011
 * @link http://code.google.com/p/limba
 */

class PermissionGenerator extends Generator{
	function setUp(){
		$this->content ="";
		if($_SESSION['USER_BEAN']->belongsToGroupLabel("security")){
			$perm = $this->params['currentAccess']->getPermission();
			$this->content .= '<fieldset> <legend>'.$this->params['translator']->perm.'</legend> '."\n";
			$this->content .= '	<fieldset class="perm"><legend>Owner</legend>'."\n";
			$this->content .= '		<select name="{perm}_ownread" id="{perm}_ownread" title="read"><option value="0">0</option><option value="1">1</option></select>'."\n";
			$this->content .= '		<select name="{perm}_ownwrite" id="{perm}_ownwrite" title="write"><option value="0">0</option><option value="1">1</option></select>'."\n";
			$this->content .= '		<select name="{perm}_ownupdt" id="{perm}_ownupdt" title="update"><option value="0">0</option><option value="1">1</option></select>'."\n";
			$this->content .= '		<select name="{perm}_owndel" id="{perm}_owndel" title="delete"><option value="0">0</option><option value="1">1</option></select>'."\n";
			$this->content .= '	</fieldset>'."\n";
			$this->content .= '	<fieldset class="perm"><legend>Group</legend>'."\n";
			$this->content .= '		<select name="{perm}_grpread" id="{perm}_grpread" title="read"><option value="0">0</option><option value="1">1</option></select>'."\n";
			$this->content .= '		<select name="{perm}_grpwrite" id="{perm}_grpwrite" title="write"><option value="0">0</option><option value="1">1</option></select>'."\n";
			$this->content .= '		<select name="{perm}_grpupdt" id="{perm}_grpupdt" title="update"><option value="0">0</option><option value="1">1</option></select>'."\n";
			$this->content .= '		<select name="{perm}_grpdel" id="{perm}_grpdel" title="delete"><option value="0">0</option><option value="1">1</option></select>'."\n";
			$this->content .= '	</fieldset>'."\n";
			$this->content .= '	<fieldset class="perm"><legend>Other</legend>'."\n";
			$this->content .= '		<select name="{perm}_othread" id="{perm}_othread" title="read"><option value="0">0</option><option value="1">1</option></select>'."\n";
			$this->content .= '		<select name="{perm}_othwrite" id="{perm}_othwrite" title="write"><option value="0">0</option><option value="1">1</option></select>'."\n";
			$this->content .= '		<select name="{perm}_othupdt" id="{perm}_othupdt" title="update"><option value="0">0</option><option value="1">1</option></select>'."\n";
			$this->content .= '		<select name="{perm}_othdel" id="{perm}_othdel" title="delete"><option value="0">0</option><option value="1">1</option></select>'."\n";
			$this->content .= '	</fieldset>'."\n";
			$this->content .= '</fieldset>'."\n";
			$this->content .= '<script type="text/javascript">'."\n";
			$this->content .= '	setPermVal(\''.$this->params['currentAccess']->getPermission().'\');'."\n";
			$this->content .= '</script>'."\n";
		}
		
	}
}
?>