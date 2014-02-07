<?php
/**
 * @package limba.generators.admin.components.forms
 * @author  Ludovic Reenaers
 * @since 26 oct. 2010
 * @link http://code.google.com/p/limba
 */

class ProfileAddGenerator extends FormGenerator{
	function setUp(){
		$TokenDAO = $this->Factory->getTokenDAO();
		$tokens = $TokenDAO->getAll();
		$template='<form  ACCEPT-CHARSET="UTF-8" name="admProfile" action="'.$_SERVER['SCRIPT_NAME'].'?/profile/insert/" method="post"  onsubmit="selectValid(\'toBox\');" >'."\n";
		$template .= '<fieldset>'."\n";
		$template .= '	<legend>'.$this->params['translator']->newProf.'</legend>'."\n";
		$template .= '		<table cellpadding="3px" cellspacing="10px"><tr> '."\n";
		$template .= '		<th>'.$this->params['translator']->labelNom.'</th><td> <input type="text" name="profname"/></td></tr><tr><th>'.$this->params['translator']->comment.'</th><td> <textarea name="profcomm"></textarea></td></tr><tr>'."\n";
		$template .= '		<td colspan="2"><select name="from[]" id="fromBox" multiple="multiple" onmouseover="sortList(\'fromBox\');" class="lsBox">'."\n";
		foreach ($tokens as $token){
			$template .= '			<option value="'.$token->getId().'">'.$token->getLabel().'</option>'."\n";
		}
		$template .= '		</select></td><td>'."\n";
		$template .= '<input name="add" type="button" value="'.$this->params['translator']->add.'"	onclick="moveSelected(\'fromBox\',\'toBox\');" /> '."\n";
		$template .= '<input name="remove" type="button" value="'.$this->params['translator']->remove.'" onclick="moveSelected(\'toBox\',\'fromBox\');" /></td><td>'."\n";
		$template .= '		<select name="too[]" id="toBox" multiple="multiple" onmouseover="sortList(\'toBox\');" class="lsBox">'."\n";
		$template .= '		</select></td></tr><tr><td colspan="3">'."\n";
		$template .= '<input type="submit" name="go" value="'.$this->params['translator']->add.'" style="float:right;font-size:150%;"/></td></tr></table>'."\n";
		$template .= '</fieldset>'."\n";
		$template.='</form>'."\n";
		$wraped = "";
		foreach ($this->children as $child){
			$wraped.=$child->dump();
		}
		$this->content = str_replace("{WRAP-HERE}",$wraped,$template);
	}
}