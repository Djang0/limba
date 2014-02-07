<?php
/**
 * @package limba.generators.public.properties
 * @author  Ludovic Reenaers
 * @since 9 déc. 2010
 * @link http://code.google.com/p/limba
 */

class DocumentGenerator extends WrapablePropertyGenerator{
	protected function getAddByIso($iso){
		return $this->getAdd();
	}
	protected function getEditByIso($iso){
		return $this->getEdit();
	}
	protected function getShow(){
		
		$title=$this->Property->getLabel($_SESSION['langue']);
		$template='{WRAP-HERE}';
		if($_SERVER['SCRIPT_NAME']=='/embed.php'){
			$post = '<a href="#" onClick="history.go(-2)" title="'.$this->params['translator']->back.'">'.$this->params['translator']->back.'</a>';
		}else{
			$post = '';
		}
		
		$pre = '<h2 title="'.$this->Property->getTooltip($_SESSION['langue']).'">'.$title.'</h2>';
		
		$post = '';	
		return $pre.$template.$post;
	}
	protected function getAdd(){
		//FormManager::start($this->params["module"],$this->params["action"]);
		$act= $this->params["action"];
		$url = "?/".$this->params["module"]."/insert/";
		$title = $this->params['translator']->$act." ".$this->Property->getTypeDocument()->getLabel();
		$parent = $this->params['rootCat']->getChildCategory($this->params['targetcatid']);
		if($this->mode=='ADM'){
			$template='<div id="summary">'."\n";
			
			$template.='	<div class="title"><a href="'.$_SERVER['SCRIPT_NAME'].'?/category/admin/'.$parent->getId().'/'.$parent->getLabel($_SESSION['langue']).'">'.$parent->getLabel($_SESSION['langue']).'</a></div>'."\n";
			$template.='	<div class="desc"><a href="'.$_SERVER['SCRIPT_NAME'].'?/category/admin/'.$parent->getId().'/'.$parent->getLabel($_SESSION['langue']).'">'.$parent->getTooltip($_SESSION['langue']).'</a></div>'."\n";
			$template.='	<div class="icons">'."\n";
			$template.='		<img src="/img/internals/cancel.png" title="'.$this->params['translator']->cancel.'" alt="'.$this->params['translator']->cancel.'" onclick="javascript:document.location.href=\'/admin.php?/category/admin/'.$parent->getId().'/\';"/><div class="details"><img src="/img/internals/user.png" title="'.$this->params['translator']->owner.'" alt="'.$this->params['translator']->owner.'"/> '.$parent->getOwnerId().' <img src="/img/internals/group.png" title="'.$this->params['translator']->grp.'" alt="'.$this->params['translator']->grp.'"/> '.$parent->getGroupId().' <img src="/img/internals/lock.png" title="'.$this->params['translator']->perm.'" alt="'.$this->params['translator']->perm.'"/><span class="own">'.substr($parent->getPermission(),0,4).'</span><span class="grp">'.substr($parent->getPermission(),4,4).'</span><span class="oth">'.substr($parent->getPermission(),8,4).'</span><img src="/img/internals/created.png" title="'.$this->params['translator']->crDate.'" alt="'.$this->params['translator']->crDate.'"/> '.$parent->getCreated().' <img src="/img/internals/updated.png" title="'.$this->params['translator']->upDate.'" alt="'.$this->params['translator']->upDate.'"/> '.$parent->getUpdated().'</div>'."\n";
			$template.='	</div>'."\n";
			$template.='	<div class="subtitle">'.$this->params['translator']->content.' </div>'."\n";
			$template.='	<div id="Document">'."\n";
			$template.='		<h2>'.$title.'</h2>'."\n";
			$template.='		<form ACCEPT-CHARSET="'.$_SESSION['encoding'].'" name="'.$this->params["module"].$this->params["action"].'" action="'.$_SERVER['SCRIPT_NAME'].$url.'" method="post">'."\n";
			$template.= '			<input type="hidden" name="targetcatid" value="'.$this->params["targetcatid"].'"/><input type="hidden" name="typedocid" value="'.$this->params["typeid"].'"/>'."\n";
	
			$template.= '			<ol id="toc">'."\n";
			$lngDAO = $this->Factory->getLangueDAO();
			$langs = $lngDAO->All();
			foreach ($langs as $Lang){
				$template.='				<li><a href="#page-'.$Lang->getIso().'"><span>'.$Lang->getIso().'</span></a></li>'."\n";
			}		
			$template.='			</ol>'."\n";
			foreach ($langs as $Lang){
				$template .= '			<div class="subcontent" id="page-'.$Lang->getIso().'">'."\n";
				
				$template.='		<fieldset><legend>'.$this->params['translator']->meta.'</legend><table><tr><td>'.$this->params['translator']->labelNom.' ('.$Lang->getIso().')</td><td><input type="text" name="{meta}_label_'.$Lang->getIso().'"/></td></tr>'."\n";
				$template.='			<tr><td>'.$this->params['translator']->infobulle.' ('.$Lang->getIso().')</td><td><input type="text" name="{meta}_tooltip_'.$Lang->getIso().'"/></td></tr></table></fieldset>'."\n";
				
				$template.='		<fieldset><legend>'.$this->params['translator']->props.'</legend>'."\n";
				$template.='			<table>'."\n";
				foreach ($this->children as $child){
					$template.=$child->getAddByIso($Lang->getIso());
				}
				$template.='			</table>'."\n".'		</fieldset>'."\n";
				
				$template .= '	</div>'."\n";
			}	
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
		}else{
			$template='<div id="summary">'."\n";
			$template.='	<form ACCEPT-CHARSET="'.$_SESSION['encoding'].'" name="'.$this->params["module"].$this->params["action"].'" action="'.$_SERVER['SCRIPT_NAME'].$url.'" method="post">'."\n";
			$template.= '		<input type="hidden" name="targetcatid" value="'.$this->params["targetcatid"].'"/><input type="hidden" name="typedocid" value="'.$this->Property->getTypeDocument()->getId().'"/>'."\n";
			$template.= '		<table>'."\n";
			foreach ($this->children as $child){
					
					$template.='		'.$child->getAddByIso($_SESSION['langue'])."\n";
				}
			$template.= '		</table>'."\n";				
			$template .= '	<input type="submit" value="'.$this->params['translator']->$act.'"/></form>'."\n";
			$template.='</div>'."\n";
		}
		return $template;
	}
	protected function getEdit(){
		//FormManager::start($this->params["module"],$this->params["action"]);
		$act= $this->params["action"];
		$url = "?/".$this->params["module"]."/update/";
		$title = $this->params['translator']->$act." ".$this->Property->getTypeDocument()->getLabel();
		
		$template='<div id="summary">'."\n";
		$template.='	<div class="title"><a href="'.$_SERVER['SCRIPT_NAME'].'?/document/admin/'.$this->Property->getId().'/'.$this->Property->getLabel($_SESSION['langue']).'">'.$this->Property->getLabel($_SESSION['langue']).'</a></div>'."\n";
		$template.='	<div class="desc"><a href="'.$_SERVER['SCRIPT_NAME'].'?/document/admin/'.$this->Property->getId().'/'.$this->Property->getLabel($_SESSION['langue']).'">'.$this->Property->getTooltip($_SESSION['langue']).'</a></div>'."\n";
		$template.='	<div class="icons">'."\n";
		$template.='		<img src="/img/internals/tool.png" title="'.$this->params['translator']->edit.'" alt="'.$this->params['translator']->edit.'" onclick="javascript:document.location.href=\'/admin.php?/document/edit/'.$this->Property->getId().'/\';"/><div class="details"><img src="/img/internals/user.png" title="'.$this->params['translator']->owner.'" alt="'.$this->params['translator']->owner.'"/> '.$this->Property->getOwnerId().' <img src="/img/internals/group.png" title="'.$this->params['translator']->grp.'" alt="'.$this->params['translator']->grp.'"/> '.$this->Property->getGroupId().' <img src="/img/internals/lock.png" title="'.$this->params['translator']->perm.'" alt="'.$this->params['translator']->perm.'"/><span class="own">'.substr($this->Property->getPermission(),0,4).'</span><span class="grp">'.substr($this->Property->getPermission(),4,4).'</span><span class="oth">'.substr($this->Property->getPermission(),8,4).'</span><img src="/img/internals/created.png" title="'.$this->params['translator']->crDate.'" alt="'.$this->params['translator']->crDate.'"/> '.$this->Property->getCreated().' <img src="/img/internals/updated.png" title="'.$this->params['translator']->upDate.'" alt="'.$this->params['translator']->upDate.'"/> '.$this->Property->getUpdated().'</div>'."\n";
		$template.='	</div>'."\n";
		$template.='	<div class="subtitle">'.$this->params['translator']->content.'</div>'."\n";
		$template.='	<div id="Document">'."\n";
		$template.='	<h2>'.$title.'</h2>'."\n";
		$template.='	<form ACCEPT-CHARSET="'.$_SESSION['encoding'].'" name="'.$this->params["module"].$this->params["action"].'" action="'.$_SERVER['SCRIPT_NAME'].$url.'" method="post">'."\n";
		$template.= '		<input type="hidden" name="currentid" value="'.$this->params['currentid'].'"/>'."\n";
		
		$template.= '			<ol id="toc">'."\n";
		$lngDAO = $this->Factory->getLangueDAO();
		$langs = $lngDAO->All();
		foreach ($langs as $Lang){
			$template.='				<li><a href="#page-'.$Lang->getIso().'"><span>'.$Lang->getIso().'</span></a></li>'."\n";
		}		
		$template.='			</ol>'."\n";
		foreach ($langs as $Lang){
			$template .= '			<div class="subcontent" id="page-'.$Lang->getIso().'">'."\n";
			
			$template.='				<fieldset><legend>'.$this->params['translator']->meta.'</legend><table><tr><td>'.$this->params['translator']->labelNom.' ('.$Lang->getIso().')</td><td><input type="text" name="{meta}_label_'.$Lang->getIso().'" value="'.$this->Property->getLabel($Lang->getIso()).'"/></td></tr>'."\n";
			$template.='				<tr><td>'.$this->params['translator']->infobulle.' ('.$Lang->getIso().')</td><td><input type="text" name="{meta}_tooltip_'.$Lang->getIso().'" value="'.$this->Property->getTooltip($Lang->getIso()).'"/></td></tr></table></fieldset>'."\n";
			
			$template.='				<fieldset><legend>'.$this->params['translator']->props.'</legend>'."\n";
			$template.='				<table>'."\n";
			foreach ($this->children as $child){
				$template.=$child->getEditByIso($Lang->getIso());
			}
			$template.='				</table></fieldset>'."\n";
			
			$template .= '			</div>'."\n";
		}	
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
	protected function getAdmin(){
		$bean = $this->params['rootCat']->getDocument($this->params['currentid']);
		$template='<div id="summary">'."\n";
		$template.='	<div class="title"><a href="'.$_SERVER['SCRIPT_NAME'].'?/document/admin/'.$bean->getId().'/'.$bean->getLabel($_SESSION['langue']).'">'.$bean->getLabel($_SESSION['langue']).'</a></div>'."\n";
		$template.='	<div class="desc"><a href="'.$_SERVER['SCRIPT_NAME'].'?/document/admin/'.$bean->getId().'/'.$bean->getLabel($_SESSION['langue']).'">'.$bean->getTooltip($_SESSION['langue']).'</a></div>'."\n";
		$template.='	<div class="icons">'."\n";
		$template.='		<img src="/img/internals/tool.png" title="'.$this->params['translator']->edit.'" alt="'.$this->params['translator']->edit.'" onclick="javascript:document.location.href=\'/admin.php?/document/edit/'.$this->Property->getId().'/\';"/><div class="details"><img src="/img/internals/user.png" title="'.$this->params['translator']->owner.'" alt="'.$this->params['translator']->owner.'"/> '.$this->Property->getOwnerId().' <img src="/img/internals/group.png" title="'.$this->params['translator']->grp.'" alt="'.$this->params['translator']->grp.'"/> '.$this->Property->getGroupId().' <img src="/img/internals/lock.png" title="'.$this->params['translator']->perm.'" alt="'.$this->params['translator']->perm.'"/><span class="own">'.substr($this->Property->getPermission(),0,4).'</span><span class="grp">'.substr($this->Property->getPermission(),4,4).'</span><span class="oth">'.substr($this->Property->getPermission(),8,4).'</span><img src="/img/internals/created.png" title="'.$this->params['translator']->crDate.'" alt="'.$this->params['translator']->crDate.'"/> '.$this->Property->getCreated().' <img src="/img/internals/updated.png" title="'.$this->params['translator']->upDate.'" alt="'.$this->params['translator']->upDate.'"/> '.$this->Property->getUpdated().'</div>'."\n";
		$template.='	</div>'."\n";
		$template.='	<div class="subtitle">'.$this->params['translator']->content.'</div>'."\n";
		$template.='	<div id="Document">'."\n";
		$template.='		{WRAP-HERE}'."\n";
		$template.='	</div>'."\n";
		$template.='	<div class="bottomicons">'."\n";
		$template.='		<img src="/img/internals/tool.png" title="'.$this->params['translator']->edit.'" alt="'.$this->params['translator']->edit.'" onclick="javascript:document.location.href=\'/admin.php?/document/edit/'.$this->Property->getId().'/\';"/>'."\n";
		$template.='	</div>'."\n";
		$template.='</div>'."\n";
		return $template;
	}


}
?>