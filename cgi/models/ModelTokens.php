<?php
/**
 * @package limba.models
 * @author  Ludovic Reenaers
 * @since 19 mai. 2011
 * @link http://code.google.com/p/limba
 */

class ModelTokens extends Model{
	function update(){
		$DAO = $this->factory->getTokenDAO();
		$tok = $DAO->getById((int)$this->params["targettkid"]);
		if(!is_null($tok)){
			$tok->setLabel($_POST['token']);
			$DAO->update($tok);
		}
		return "";
	}
	function insert(){
		//echo "toto";
		$DAO = $this->factory->getTokenDAO();
		$tok = new Token(0);
		$tok->setLabel($_POST['token']);
		$DAO->add($tok);
		return "";
	}
	function edit(){
		
		FormManager::setUrls($_SERVER['REQUEST_URI'],$_SERVER['REQUEST_URI']);
		$page="";
		$DAO = $this->factory->getTokenDAO();
		
		$tok = $DAO->getById((int)$this->params['targettkid']);
		
		if(!is_null($tok)){
		
			$page .= '<form ACCEPT-CHARSET="UTF-8" name="AddTranslation" action="'.$_SERVER['SCRIPT_NAME'].'?/tokens/update/" method="post">'."\n";
			$page .= '		<input type="hidden" name="currentid" value="'.$tok->getId().'">'."\n";
			$page .= '		<input type="text" name="token" value="'.$tok->getLabel().'"/>'."\n";
			$page .= '		<input type="submit" value="'.$this->params['translator']->edit.'"/>'."\n";
			$page .= '</form>'."\n";
		}
		return $page;
	}
	function add(){
		FormManager::setUrls($_SERVER['REQUEST_URI'],$_SERVER['REQUEST_URI']);
		$page="";
		$page .= '<form ACCEPT-CHARSET="UTF-8" name="AddTranslation" action="'.$_SERVER['SCRIPT_NAME'].'?/tokens/insert/" method="post">'."\n";
		$page .= '		<input type="text" name="token" />'."\n";
		$page .= '		<input type="submit" value="'.$this->params['translator']->add.'"/>'."\n";
		$page .= '</form>'."\n";
		return $page;
	}
	function admin(){
		$page ="";
		$DAO = $this->factory->getTokenDAO();
		$tokens = $DAO->getAll();
		
		$page.= '<table cellspacing="0" cellpadding="0" border="0" class="display" id="dynTab">'."\n";
		$page.= '	<thead>'."\n";
		$page.= '		<th>ID<span>&nbsp;&nbsp;&nbsp;</span></th>'."\n";
		$page.= '		<th>Token<span>&nbsp;&nbsp;&nbsp;</span></th>'."\n";
		$page.= '	</thead><tbody>'."\n";
		foreach ($tokens as $tok){
			$page.= '				<tr>';
			$page.= '<td><img src="/img/internals/tool.png" alt="Edit" title="Edit" onclick="loadContent(\'#listing\', \'http://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'].'?/tokens/edit/'.$tok->getId().'\');"/> '.$tok->getId().'</td>'."\n";
			$page.= '			<td>'.$tok->getLabel().'</td>'."\n";
			$page.= '				</tr>';
		}
		$page.= '</tbody>'."\n";
		$page.= '	<tfoot>'."\n";
		$page.= '		<th>ID<span>&nbsp;&nbsp;&nbsp;</span></th>'."\n";
		$page.= '		<th>Token<span>&nbsp;&nbsp;&nbsp;</span></th>'."\n";
		$page.= '	</tfoot>'."\n";
		$page.= '</table>'."\n";
		return $page;
	}
}
?>