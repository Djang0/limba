<?php
/**
 * @package limba.models
 * @author  Ludovic Reenaers
 * @since 4 nov. 2010
 * @link http://code.google.com/p/limba
 */

class ModelTranslation extends Model{
	function insert(){
		$traDAO = $this->factory->getTranslationDAO();
		$wordDAO = $this->factory->getWordDAO();
		$lngDAO = $this->factory->getLangueDAO();
		$word = new Word(0);
		$word->setLabel($_POST["item"]);
		$word = $wordDAO->add($word);
		foreach ($_POST as $key=>$value){
			$tab = explode("_", $key);
			if($tab[0]== "{trad}"){
				$lng = $lngDAO->getByIso($tab[1]);
				$trad = new Translation(0);
				$trad->setLangue($lng);
				$trad->setLabel($value);
				$trad->setWordId($word->getId());
				$trad = $traDAO->add($trad);
			}
		}
		return "";
	}
	function add(){
		FormManager::setUrls($_SERVER['REQUEST_URI'],$_SERVER['REQUEST_URI']);
		$page="";
		$traDAO = $this->factory->getTranslationDAO();
		$wordDAO = $this->factory->getWordDAO();
		$lngDAO = $this->factory->getLangueDAO();
		//FormManager::setFallBackUrl($_SERVER['REQUEST_URI']);
		$langs = $lngDAO->All(); 
		$page .= '<form ACCEPT-CHARSET="UTF-8" name="AddTranslation" action="'.$_SERVER['SCRIPT_NAME'].'?/translation/insert/" method="post">'."\n";
		$page .= '	<table>'."\n";
		$page .= '		<thead><tr>'."\n";
		$page .= '			<th title="'.$this->params['translator']->identif.'">'.$this->params['translator']->identif.'</th>'."\n";
		foreach ($langs as $Lng){
			$page .= '			<th title="'.$Lng->getLabel($_SESSION['langue']).'">'.$Lng->getIso().'</th>'."\n";
		}
		$page .= '		</tr></thead>'."\n";
		$page .= '		<tbody><tr>'."\n";
		$page .= '			<td><input type="text" name="item" class="traKey" size="15"></td>'."\n";
		$cpt=1;
		foreach ($langs as $Lng){
			$page .= '			<td><input class="translation" type="text" name="{trad}_'.$Lng->getIso().'" size="50"></td>'."\n";
			$cpt+=1;
		}
		$page .= '		</tr><tr><td colspan="'.$cpt.'"><input type="submit" value="'.$this->params['translator']->add.'"></td></tr></tbody>'."\n";
		$page .= '	</table>'."\n";
		$page .= '</form>'."\n";
		return $page;
	}
	function admin(){
		FormManager::setUrls($_SERVER['REQUEST_URI'],$_SERVER['REQUEST_URI']);
		$wordDAO = $this->factory->getWordDAO();
		$lngDAO = $this->factory->getLangueDAO();
		$words = $wordDAO->getAll();
		$langs = $lngDAO->All(); 
		//FormManager::setFallBackUrl($_SERVER['REQUEST_URI']);
		$page = '<form ACCEPT-CHARSET="UTF-8" name="UpdateTranslations" action="'.$_SERVER['SCRIPT_NAME'].'?/translation/update/" method="post"><input type="submit" value="'.$this->params['translator']->saveall.'" style="float:right;"><table cellspacing="0" cellpadding="0" border="0" class="display" id="dynTab"> ';
		$page .= '<thead><tr><th>Item<span>&nbsp;&nbsp;&nbsp;</span></th>';
		foreach ($langs as $Lng){
			$page .= '<th>'.$Lng->getIso().'<span>&nbsp;&nbsp;&nbsp;</span></th>';
		}
		$page .= '<tr></thead><tbody>';
		if(!is_null($langs) && !is_null($words)){
			foreach ($words as $Word){
				$page .= '<tr><td>'.$Word->getLabel().'</td>';
					foreach ($langs as $Lng){
						$tr = $Word->getTranslation($Lng->getIso());
						if(!is_null($tr)){
							$page.='<td><textarea name="{set}_'.$tr->getId().'" rows="4" cols="40">'.$tr->getLabel().'</textarea> </td>';
						}else{
							$page.='<td><textarea name="{emp}_'.$Word->getId().'_'.$Lng->getIso().'" rows="4" cols="40"></textarea> </td>';
						}
					}
				$page .= '</tr>';
			}
		}
		$page.= "</tbody>";
		$page .= '<tfoot><tr><th>Item</th>';
		foreach ($langs as $Lng){
			$page .= '<th>'.$Lng->getIso().'</th>';
		}
		$page .= '<tr></tfoot></table></form>	';
		
		return  $page;
	}
	function update(){
		$traDAO = $this->factory->getTranslationDAO();
		$wordDAO = $this->factory->getWordDAO();
		$lngDAO = $this->factory->getLangueDAO();
		foreach ($_POST as $key=>$val){
			$tab = explode("_", $key);
			if($tab[0] == '{set}'){
				$tr = $traDAO->getById((int)$tab[1]);
				$tr->setLabel($val);
				$traDAO->update($tr);
			}elseif ($tab[0] == '{emp}'){
				$tr = new Translation(0);
				$tr->setLabel($val);
				$tr->setLangue($lngDAO->getByIso($tab[2]));
				$tr->setWordId((int)$tab[1]);
				$tr = $traDAO->add($tr);
			}
		}
		return  "";
	}
	
}
?>