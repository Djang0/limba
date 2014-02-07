<?php
/**
 * @package limba.models
 * @author  Ludovic Reenaers
 * @since 30 sept. 2010
 * @link http://code.google.com/p/limba
 */

class ModelLangs extends Model{
	function admin(){
		$lngDAO = $this->factory->getLangueDAO();
		$langs = $lngDAO->All();
		$strr= '<select name="lng" id="selecta" onchange="id=this.value;url=\'http://'.$_SERVER['HTTP_HOST'].'/embed.php?/langs/edit/\'+id;ajaxLoad(url,\'lngborder\',function() {});" style="margin-left:20px; font-size:150%;">';
		foreach ($langs as $Lng){
			$strr.='<option value="'.$Lng->getId().'">'.$Lng->getIso().'</option>';
		}
		$strr.= '</select><hr/><div id="lngborder"></div>';
		$strr .= '<script type="text/javascript">id=document.getElementById(\'selecta\').value;url=\'http://'.$_SERVER['HTTP_HOST'].'/embed.php?/langs/edit/\'+id;ajaxLoad(url,\'lngborder\',function() {});</script>';
		return $strr;
	}
	function update(){
		$lngDAO = $this->factory->getLangueDAO();
		$lngLabDAO = $this->factory->getLAngueLabelDAO();
		$Lng = $lngDAO->getByIso($_POST['iso']);
		foreach ($_POST as $key=>$value){
			$tab = explode("_",$key);
			if($tab[0]=='{lab}'){
				foreach ($Lng->getLabels() as $Lab){
					if($Lab->getIsoTraduction() == $tab[1]){
						$Lab->setLabel($value);
						$lngLabDAO->update($Lab);
					}
				}
			}
		}
		return "";
	}
	function insert(){
		$lngDAO = $this->factory->getLangueDAO();
		$lngLabDAO = $this->factory->getLAngueLabelDAO();
		$Lng = new Langue(0);
		$Lng->setIso($_POST['iso']);
		$Lng->setDefault(0);
		$Lng->setAvailable(1);
		$pos = $lngDAO->getLastLangue()->getOrderedPosition()+1;
		$Lng->setOrderedPosition($pos);
		$Lng = $lngDAO->add($Lng);
		foreach ($_POST as $key=>$value){
			$tab = explode("_",$key);
			if($tab[0]=='{lab}'){
				$lab = new LangueLabel(0);
				$lab->setIsoTraduction($tab[1]);
				$lab->setLabel($value);
				$lab->setlangueId((int)$Lng->getId());
				$lab = $lngLabDAO->add($lab);
			}
			if($key == 'descr'){
				$lab = new LangueLabel(0);
				$lab->setIsoTraduction($_POST['iso']);
				$lab->setLabel($value);
				$lab->setlangueId((int)$Lng->getId());
				$lab = $lngLabDAO->add($lab);
			}
		}
		return "";
	}
	
	function add(){
		FormManager::setUrls($_SERVER['REQUEST_URI'],$_SERVER['REQUEST_URI']);
		$act=$this->params["action"];
		$lngDAO = $this->factory->getLangueDAO();
		$langs = $lngDAO->All();
		$url = "?/".$this->params["module"]."/insert/";
		$strr= '<form ACCEPT-CHARSET="'.$_SESSION['encoding'].'" name="'.$this->params["module"].$act.'" action="'.$_SERVER['SCRIPT_NAME'].$url.'" method="post">'."\n";
		$strr .= '<fieldset><table><tr><td>ISO</td><td><input type="text" name="iso"/></td></tr>';
		$strr .= '<tr><td>'.$this->params['translator']->descr.'&nbsp;</td><td> <input type="text" name="descr"/></td></tr>';
		$strr .= '<tr><td>'.$this->params['translator']->available.'&nbsp;</td><td><select name="available"><option value="1">1</option><option value="0">0</option></select></td></tr></table></fieldset>';
		
		$strr .= '<fieldset><ol id="toc">';
		foreach ($langs as $Lang){
			$strr .= '				<li><a href="#page-'.$Lang->getIso().'"><span>'.$Lang->getIso().'</span></a></li>'."\n";	
		}
		$strr .= '			</ol>'."\n";
		
		foreach ($langs as $Lang){
			$strr .='			<div class="subcontent" id="page-'.$Lang->getIso().'">'."\n";
			$strr .= '				<br/>'.$this->params['translator']->descr.' '.$Lang->getIso().'&nbsp;&nbsp;<input type="text" name="{lab}_'.$Lang->getIso().'">';
			$strr .= '			</div>';
		}
		$strr .= '			<script src="/js/ext/activatables.js" type="text/javascript"></script>'."\n";
		$strr .= '			<script type="text/javascript">'."\n";
		$strr .= "				activatables('page', [";
		$bool=false;
		foreach ($langs as $Lang){
			
			if($bool){
				$strr.=", 'page-".$Lang->getIso()."'";
			}else{
				$strr.="'page-".$Lang->getIso()."'";
				$bool=true;
			}
			
		}
		$strr.=']);'."\n".'			</script>'."\n";		
		$strr .= '</fieldset><fieldset style="text-align:right;"><input type="submit" value="'.$this->params['translator']->$act.'"></fielset>';
		$strr .= '</form>';
		return $strr;
	}
	function edit(){
		FormManager::setUrls($_SERVER['REQUEST_URI'],$_SERVER['REQUEST_URI']);
		$act=$this->params["action"];
		$lngDAO = $this->factory->getLangueDAO();
		$langs = $lngDAO->All();
		$Lng = $lngDAO->getById((int)$this->params['currentid']);
		$url = "?/".$this->params["module"]."/update/";
		$strr= '<form ACCEPT-CHARSET="'.$_SESSION['encoding'].'" name="'.$this->params["module"].$act.'" action="'.$_SERVER['SCRIPT_NAME'].$url.'" method="post">'."\n";
		$strr .= '<fieldset><table><tr><td>ISO</td><td><input type="text" name="iso" value="'.$Lng->getIso().'" READONLY /></td></tr></table></fieldset>';
		$strr .= '<fieldset><ol id="toc">';
		foreach ($langs as $Lang){
			$strr .= '				<li><a href="#page-'.$Lang->getIso().'"><span>'.$Lang->getIso().'</span></a></li>'."\n";	
		}
		$strr .= '			</ol>'."\n";
		foreach ($langs as $Lang){
			$strr .='			<div class="subcontent" id="page-'.$Lang->getIso().'">'."\n";
			$strr .= '				<br/>'.$this->params['translator']->descr.' '.$Lang->getIso().'&nbsp;&nbsp;<input type="text" name="{lab}_'.$Lang->getIso().'" value="'.$Lng->getLabel($Lang->getIso()).'">';
			$strr .= '			</div>';
		}
		$strr .= '			<script src="/js/ext/activatables.js" type="text/javascript"></script>'."\n";
		$strr .= '			<script type="text/javascript">'."\n";
		$strr .= "				activatables('page', [";
		$bool=false;
		foreach ($langs as $Lang){
			if($bool){
				$strr.=", 'page-".$Lang->getIso()."'";
			}else{
				$strr.="'page-".$Lang->getIso()."'";
				$bool=true;
			}
			
		}
		$strr.=']);'."\n".'			</script>'."\n";		
		$strr .= '</fieldset><fieldset style="text-align:right;"><input type="submit" value="'.$this->params['translator']->$act.'"></fielset>';
		$strr .= '</form>';
		return $strr;
	}
	
	
}
?>