<?php
/**
 * @package limba.models
 * @author  Ludovic Reenaers
 * @since 23 sept. 2010
 * @link http://code.google.com/p/limba
 */

class ModelCategory extends Model{
	function show(){
		$dao=$this->factory->getCategoryDAO();
		$bean = $dao->getById((int)$this->params["currentid"]);	
		$alternate = $bean->getAlternate();
		if(is_null($alternate)||trim($alternate)==''){
			$generator = new CategoryPreviewGenerator($this->params, $this->factory, $bean);
		}else{
			$generator = new IframGenerator($this->params, $this->factory, $alternate);
		}
		return $generator;
	}
	function admin(){
		$gen = new CategoryAdminGenerator($this->params, $this->factory);
		return $gen->dump();
	}

	private function getTabItemByIso($tab,$iso){
		$item =null;
		foreach ($tab as $TabItem){
			if ($TabItem->getLangue()->getIso() == $iso){
				$item = $TabItem;
			}
		}
		return $item;
	}
	function add(){
		FormManager::setUrls($_SERVER['SCRIPT_NAME']."?/category/admin/".$this->params["currentid"]."/",$_SERVER['SCRIPT_NAME']."?/category/admin/".$this->params["currentid"]."/");
		$act= $this->params["action"];
		$url = "?/".$this->params["module"]."/insert/";
		$bean = $this->params['rootCat']->getChildCategory($this->params['targetcatid']);
		$title = $this->params['translator']->$act." ".$this->params['translator']->aCat;
		
		$template='<div id="summary">'."\n";
		$template.='	<div class="title"><a href="'.$_SERVER['SCRIPT_NAME'].'?/category/admin/'.$this->params['targetcatid'].'/'.$bean->getLabel($_SESSION['langue']).'">'.$bean->getLabel($_SESSION['langue']).'</a></div>'."\n";
		$template.='	<div class="desc"><a href="'.$_SERVER['SCRIPT_NAME'].'?/category/admin/'.$this->params['targetcatid'].'/'.$bean->getLabel($_SESSION['langue']).'">'.$bean->getTooltip($_SESSION['langue']).'</a></div>'."\n";
		$template.='	<div class="icons">'."\n";
		$template.='		<img src="/img/internals/white.png" title="'.$this->params['translator']->edit.'" alt="'.$this->params['translator']->edit.'" /><div class="details"><img src="/img/internals/user.png" alt="'.$this->params['translator']->owner.'" title="'.$this->params['translator']->owner.'"/> '.$bean->getOwnerId().' <img src="/img/internals/group.png" alt="'.$this->params['translator']->grp.'" title="'.$this->params['translator']->grp.'"/> '.$bean->getGroupId().' <img src="/img/internals/lock.png" alt="'.$this->params['translator']->perm.'" title="'.$this->params['translator']->perm.'"/><span class="own">'.substr($bean->getPermission(),0,4).'</span><span class="grp">'.substr($bean->getPermission(),4,4).'</span><span class="oth">'.substr($bean->getPermission(),8,4).'</span><img src="/img/internals/created.png" alt="'.$this->params['translator']->crDate.'" title="'.$this->params['translator']->crDate.'"/> '.$bean->getCreated().' <img src="/img/internals/updated.png" alt="'.$this->params['translator']->upDate.'" title="'.$this->params['translator']->upDate.'"/> '.$bean->getUpdated().'</div>'."\n";
//		
		$template.='	</div>'."\n";
		$template.='	<div class="subtitle">Content: </div>'."\n";
		$template.='	<div id="Document">'."\n";
		$template.='		<h2>'.$title.'</h2>'."\n";
		$template.='		<form ACCEPT-CHARSET="'.$_SESSION['encoding'].'" name="'.$this->params["module"].$this->params["action"].'" action="'.$_SERVER['SCRIPT_NAME'].$url.'" method="post">'."\n";
		$template.= '		<input type="hidden" name="targetcatid" value="'.$this->params['currentid'].'"/>'."\n";
		
		$template.= '			<ol id="toc">'."\n";
		$lngDAO = $this->factory->getLangueDAO();
		$langs = $lngDAO->All();
		foreach ($langs as $Lang){
			$template.='				<li><a href="#page-'.$Lang->getIso().'"><span>'.$Lang->getIso().'</span></a></li>'."\n";
		}		
		$template.='			</ol>'."\n";
		foreach ($langs as $Lang){
			$template .= '			<div class="subcontent" id="page-'.$Lang->getIso().'">'."\n";
			
			$template.='				<fieldset><legend>'.$this->params['translator']->meta.'</legend><table><tr><td>'.$this->params['translator']->labelNom.' ('.$Lang->getIso().')</td><td><input type="text" name="{meta}_label_'.$Lang->getIso().'" value="new category '.$Lang->getIso().'"/></td></tr>'."\n";
			$template.='				<tr><td>'.$this->params['translator']->infobulle.' ('.$Lang->getIso().')</td><td><input type="text" name="{meta}_tooltip_'.$Lang->getIso().'" value="new category Tooltip '.$Lang->getIso().'"/></td></tr></table></fieldset>'."\n";
			$template .= '			</div>'."\n";	
		}
		$sec = new SecuritySetGenerator($this->params, $this->factory);
		$template .= '			'.$sec->dump()."\n";
		$template .='			<script src="/js/ext/activatables.js" type="text/javascript"></script>'."\n";
		$template.='			<script type="text/javascript">'."\n";
		$template.="				activatables('page', [";
		$bool=false;
		foreach ($langs as $Lang){
			
			if($bool){
				$template.=", 'page-".$Lang->getIso()."'";
			}else{
				$template.="'page-".$Lang->getIso()."'";
				$bool=true;
			}
			
		}
		$template.=']);'."\n".'			</script>'."\n";		
		$template .='			<input type="submit" value="'.$this->params['translator']->$act.'"/></form></div>'."\n";	
		
		return $template;
		}
	function insert(){
		$DAO = $this->factory->getCategoryDAO();
		$infDAO = $this->factory->getCategoryInfoDAO();
		$langDAO = $this->factory->getLangueDAO();
		$cat = new Category(0);
		$permbin = $_POST["{perm}_ownread"].$_POST["{perm}_ownwrite"].$_POST["{perm}_ownupdt"].$_POST["{perm}_owndel"].$_POST["{perm}_grpread"].$_POST["{perm}_grpwrite"];
		$permbin .=$_POST["{perm}_grpupdt"].$_POST["{perm}_grpdel"].$_POST["{perm}_othread"].$_POST["{perm}_othwrite"].$_POST["{perm}_othupdt"].$_POST["{perm}_othdel"];
		$cat->setPermission($permbin);
		$cat->setParentCategoryId((int)$_POST['targetcatid']);
		$cat->setAlternate($_POST['{sec}_alternate']);
		$cat->setVisible($_POST['{sec}_Visible']);
		$cat->setGroupId((int)$_POST['{sec}_GroupId']);
		$cat->setOwnerId((int)$_POST['{sec}_OwnerId']);
		$cat->setRootFlag(0);
		$cat=$DAO->add($cat);
		$infoTab = array();
		foreach ($_POST as $key=>$value){
			$tab = explode("_",$key);
			if($tab[0] == "{meta}"){
				$inf = $this->getTabItemByIso($infoTab, $tab[2]);
				if(is_null($inf)){
					$inf = new CategoryInfo(0);
					$inf->setCategoryId((int)$cat->getId());
					$Langue = $langDAO->getByIso($tab[2]);
					$inf->setLangue($Langue);
					$inf=$infDAO->add($inf);
					array_push($infoTab, $inf);
				}
				$meth = "set".ucfirst($tab[1]);
				
				$inf->$meth($value);
				$infDAO->update($inf);
			}
		}
		return "";
	}
			
	function edit(){
		FormManager::setUrls($_SERVER['SCRIPT_NAME']."?/category/admin/".$this->params["currentid"]."/",$_SERVER['SCRIPT_NAME']."?/category/admin/".$this->params["currentid"]."/");
		$act= $this->params["action"];
		$url = "?/".$this->params["module"]."/update/";
		$bean = $this->params['rootCat']->getChildCategory($this->params['currentid']);
		$title = $this->params['translator']->$act." ".$this->params['translator']->aCat;
		$template='<div id="summary">'."\n";
		$template.='	<div class="title"><a href="'.$_SERVER['SCRIPT_NAME'].'?/category/admin/'.$this->params['currentid'].'/'.$bean->getLabel($_SESSION['langue']).'">'.$bean->getLabel($_SESSION['langue']).'</a></div>'."\n";
		$template.='	<div class="desc"><a href="'.$_SERVER['SCRIPT_NAME'].'?/category/admin/'.$this->params['currentid'].'/'.$bean->getLabel($_SESSION['langue']).'">'.$bean->getTooltip($_SESSION['langue']).'</a></div>'."\n";
		$template.='	<div class="icons">'."\n";
		$template.='		<img src="/img/internals/tool.png" title="'.$this->params['translator']->edit.'" alt="'.$this->params['translator']->edit.'" onclick="javascript:document.location.href=\'/admin.php?/category/edit/'.$bean->getId().'/\';"/><div class="details"><img src="/img/internals/user.png" title="'.$this->params['translator']->owner.'" alt="'.$this->params['translator']->owner.'"/> '.$bean->getOwnerId().' <img src="/img/internals/group.png" title="'.$this->params['translator']->grp.'" alt="'.$this->params['translator']->grp.'"/> '.$bean->getGroupId().' <img src="/img/internals/lock.png" title="'.$this->params['translator']->perm.'" alt="'.$this->params['translator']->perm.'"/><span class="own">'.substr($bean->getPermission(),0,4).'</span><span class="grp">'.substr($bean->getPermission(),4,4).'</span><span class="oth">'.substr($bean->getPermission(),8,4).'</span><img src="/img/internals/created.png" title="'.$this->params['translator']->crDate.'" alt="'.$this->params['translator']->crDate.'"/> '.$bean->getCreated().' <img src="/img/internals/updated.png" title="'.$this->params['translator']->upDate.'" alt="'.$this->params['translator']->upDate.'"/> '.$bean->getUpdated().'</div>'."\n";
		$template.='	</div>'."\n";
		$template.='	<div class="subtitle">Content: </div>'."\n";
		$template.='	<div id="Document">'."\n";
		$template.='		<h2>'.$title.'</h2>'."\n";
		$template.='		<form ACCEPT-CHARSET="'.$_SESSION['encoding'].'" name="'.$this->params["module"].$this->params["action"].'" action="'.$_SERVER['SCRIPT_NAME'].$url.'" method="post">'."\n";
		$template.= '		<input type="hidden" name="currentid" value="'.$this->params['currentid'].'"/>'."\n";
		
		$template.= '			<ol id="toc">'."\n";
		$lngDAO = $this->factory->getLangueDAO();
		$langs = $lngDAO->All();
		foreach ($langs as $Lang){
			$template.='				<li><a href="#page-'.$Lang->getIso().'"><span>'.$Lang->getIso().'</span></a></li>'."\n";
		}		
		$template.='			</ol>'."\n";
		foreach ($langs as $Lang){
			$template .= '			<div class="subcontent" id="page-'.$Lang->getIso().'">'."\n";
			
			$template.='				<fieldset><legend>'.$this->params['translator']->meta.'</legend><table><tr><td>'.$this->params['translator']->labelNom.' ('.$Lang->getIso().')</td><td><input type="text" name="{meta}_label_'.$Lang->getIso().'" value="'.$bean->getLabel($Lang->getIso()).'"/></td></tr>'."\n";
			$template.='				<tr><td>'.$this->params['translator']->infobulle.' ('.$Lang->getIso().')</td><td><input type="text" name="{meta}_tooltip_'.$Lang->getIso().'" value="'.$bean->getTooltip($Lang->getIso()).'"/></td></tr></table></fieldset>'."\n";
			$template .= '			</div>'."\n";	
		}
		$sec = new SecuritySetGenerator($this->params, $this->factory);
		$template .= '			'.$sec->dump()."\n";
		$template .='			<script src="/js/ext/activatables.js" type="text/javascript"></script>'."\n";
		$template.='			<script type="text/javascript">'."\n";
		$template.="				activatables('page', [";
		$bool=false;
		foreach ($langs as $Lang){
			
			if($bool){
				$template.=", 'page-".$Lang->getIso()."'";
			}else{
				$template.="'page-".$Lang->getIso()."'";
				$bool=true;
			}
			
		}
		$template.=']);'."\n".'			</script>'."\n";		
		$template .='			<input type="submit" value="'.$this->params['translator']->$act.'"/></form></div>'."\n";	
		
		return $template;
		}
	function update(){
		$catid = $_POST["currentid"];
		$DAO = $this->factory->getCategoryDAO();
		$cat = $DAO->getById((int)$catid);
		$permbin = $_POST["{perm}_ownread"].$_POST["{perm}_ownwrite"].$_POST["{perm}_ownupdt"].$_POST["{perm}_owndel"].$_POST["{perm}_grpread"].$_POST["{perm}_grpwrite"];
		$permbin .=$_POST["{perm}_grpupdt"].$_POST["{perm}_grpdel"].$_POST["{perm}_othread"].$_POST["{perm}_othwrite"].$_POST["{perm}_othupdt"].$_POST["{perm}_othdel"];
		$cat->setPermission($permbin);
		$cat->setAlternate($_POST['{sec}_alternate']);
		$cat->setVisible($_POST['{sec}_Visible']);
		$cat->setGroupId((int)$_POST['{sec}_GroupId']);
		$cat->setOwnerId((int)$_POST['{sec}_OwnerId']);
		foreach($_POST as $key=>$val){
			$tab = explode("_",$key);
			if($tab[0] == "{meta}"){
				$cat->setMeta($tab[1],$tab[2],$val);
			}
		}
		$DAO->update($cat);
		return "";
	}
}
?>
