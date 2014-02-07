<?php
/**
 * @package limba.models
 * @author  Ludovic Reenaers
 * @since 02 mar. 2011
 * @link http://code.google.com/p/limba
 */

class ModelProfile extends Model{
	function edit(){
		FormManager::setUrls($_SERVER['SCRIPT_NAME']."?/profile/admin/","http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		$generator = new ProfileFormGenerator($this->params, $this->factory);
		return $generator;
	}
	function update(){
		$profDao = $this->factory->getProfileDAO();
		$tkDao = $this->factory->getTokenDAO();
		$prof = $profDao->getById((int)$_POST['profId']);
		$prof->setLabel($_POST['label']);
		$prof->setComment($_POST['comment']);
		$tokens = array();
		if( array_key_exists('too',$_POST)){
			foreach ($_POST['too'] as $key=>$value){
				$tok = $tkDao->getById((int)$value);
				array_push($tokens,$tok);
			}
		}
		$prof->setTokens($tokens);
		$bool = $profDao->update($prof);
		if(!$bool){
			trigger_error("ERR_FAILED_UPDATE", E_USER_ERROR);
		}
		return "done!";
	}
	function add(){
		FormManager::setUrls($_SERVER['REQUEST_URI'],$_SERVER['REQUEST_URI']);
		//FormManager::setUrls('/','/');
		$page="";
		$page .= '<form ACCEPT-CHARSET="UTF-8" name="AddProfile" action="'.$_SERVER['SCRIPT_NAME'].'?/profile/insert/" method="post">'."\n";
		$page .= '<table cellspacing="12px"><tr><td>';
		$page .= '		Profile : <input type="text" name="profile" />'."\n";
		$page .= '		</td><td>Commentaire : <input type="text" name="comment" size="50"/></td></tr>'."\n";
		$page .= '		<tr><td colspan="2" ><input type="submit" style="float:right;" value="'.$this->params['translator']->add.'"/></td>'."\n";
		$page .= '</tr></table>';
		$page .= '</form>'."\n";
		return $page;
	}
	function insert(){
		$DAO = $this->factory->getProfileDAO();
		$prof = new Profile(0);
		$prof->setLabel($_POST['profile']);
		$prof->setComment($_POST['comment']);
		$prof->setAvailable(1);
		$DAO->add($prof);
		return "";
	}
	function admin(){
		$page ="";
		$DAO = $this->factory->getProfileDAO();
		$profiles = $DAO->getAll();
		
		$page.= '<table cellspacing="0" cellpadding="0" border="0" class="display" id="dynTab">'."\n";
		$page.= '	<thead>'."\n";
		$page.= '		<th>Label<span>&nbsp;&nbsp;&nbsp;</span></th>'."\n";
		$page.= '		<th>Comment<span>&nbsp;&nbsp;&nbsp;</span></th>'."\n";
		$page.= '		<th>Disponible<span>&nbsp;&nbsp;&nbsp;</span></th>'."\n";
		$page.= '	</thead><tbody>'."\n";
		foreach ($profiles as $prof){
			$page.= '				<tr>';
			$page.= '<td><img src="/img/internals/tool.png" alt="Edit" title="Edit" onclick="loadContent(\'#listing\', \'http://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'].'?/profile/edit/'.$prof->getId().'\');"/> '.$prof->getLabel().'</td>'."\n";
			$page.= '			<td>'.$prof->getComment().'</td>'."\n";
			$page.= '			<td>'.$prof->getAvailable().'</td>'."\n";
			$page.= '				</tr>';
		}
		$page.= '</tbody>'."\n";
		$page.= '	<tfoot>'."\n";
		$page.= '		<th>Label<span>&nbsp;&nbsp;&nbsp;</span></th>'."\n";
		$page.= '		<th>Comment<span>&nbsp;&nbsp;&nbsp;</span></th>'."\n";
		$page.= '		<th>Disponible<span>&nbsp;&nbsp;&nbsp;</span></th>'."\n";
		$page.= '	</tfoot>'."\n";
		$page.= '</table>'."\n";
		return $page;
	}
}
?>