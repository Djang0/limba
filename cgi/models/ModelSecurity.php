<?php
/**
 * @package limba.models
 * @author  Ludovic Reenaers
 * @since 24 fev. 2011
 * @link http://code.google.com/p/limba
 */

class ModelSecurity extends Model{
	function admin(){
		$page ="";
		$usrDAO = $this->factory->getUserDAO();
		$users = $usrDAO->getAll();
		
		$page.= '<table cellspacing="0" cellpadding="0" border="0" class="display" id="dynTab">'."\n";
		$page.= '	<thead>'."\n";
		$page.= '		<th>'.$this->params['translator']->labelNom.'<span>&nbsp;&nbsp;&nbsp;</span></th>'."\n";
		$page.= '		<th>'.$this->params['translator']->labelPrenom.'<span>&nbsp;&nbsp;&nbsp;</span></th>'."\n";
		$page.= '		<th>'.$this->params['translator']->labelEmail.'<span>&nbsp;&nbsp;&nbsp;</span></th>'."\n";
		$page.= '		<th>'.$this->params['translator']->lastIp.'<span>&nbsp;&nbsp;&nbsp;</span></th>'."\n";
		$page.= '		<th>'.$this->params['translator']->crDate.'<span>&nbsp;&nbsp;&nbsp;</span></th>'."\n";
		$page.= '		<th>'.$this->params['translator']->conDate.'<span>&nbsp;&nbsp;&nbsp;</span></th>'."\n";
		$page.= '	</thead><tbody>'."\n";
		foreach ($users as $Usr){
			$page.= '				<tr>';
			$page.= '<td><img src="/img/internals/tool.png" alt="Edit" title="Edit" onclick="loadContent(\'#listing\', \'http://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'].'?/admin/useredit/'.$Usr->getId().'\');"/> '.$Usr->getName().'</td>'."\n";
			//$page.= '			<td><img src="/img/internals/tool.png" alt="Edit" title="Edit" onclick="document.location.href=\''.$_SERVER['SCRIPT_NAME'].'?/admin/useredit/'.$Usr->getId().'\'"/> '.$Usr->getName().'</td>'."\n";
			$page.= '			<td>'.$Usr->getSurname().'</td>'."\n";
			$page.= '			<td>'.$Usr->getEmail().'</td>'."\n";
			$page.= '			<td>'.$Usr->getIp().'</td>'."\n";
			$page.= '			<td>'.$Usr->getCreated().'</td>'."\n";
			$page.= '			<td>'.$Usr->getLastConnected().'</td>'."\n";
			$page.= '				</tr>';
		}
		$page.= '</tbody>'."\n";
		$page.= '	<tfoot>'."\n";
		$page.= '		<th>'.$this->params['translator']->labelNom.'<span>&nbsp;&nbsp;&nbsp;</span></th>'."\n";
		$page.= '		<th>'.$this->params['translator']->labelPrenom.'<span>&nbsp;&nbsp;&nbsp;</span></th>'."\n";
		$page.= '		<th>'.$this->params['translator']->labelEmail.'<span>&nbsp;&nbsp;&nbsp;</span></th>'."\n";
		$page.= '		<th>'.$this->params['translator']->lastIp.'<span>&nbsp;&nbsp;&nbsp;</span></th>'."\n";
		$page.= '		<th>'.$this->params['translator']->crDate.'<span>&nbsp;&nbsp;&nbsp;</span></th>'."\n";
		$page.= '		<th>'.$this->params['translator']->conDate.'<span>&nbsp;&nbsp;&nbsp;</span></th>'."\n";
		$page.= '	</tfoot>'."\n";
		$page.= '</table>'."\n";
		return $page;
	}
}
?>