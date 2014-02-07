<?php
/**
 * @package limba.generators.admin.components.elements
 * @author  Ludovic Reenaers
 * @since 21 oct. 2010
 * @link http://code.google.com/p/limba
 */

class CategoryAdminGenerator extends Generator{
	function setUp(){
		if($_SESSION['USER_BEAN']->belongsToGroupLabel("administration")){
			$bean = $this->params['rootCat']->getChildCategory($this->params['currentid']);
			$this->content='<div id="summary">'."\n";
			$this->content.='	<div class="title"><a href="'.$_SERVER['SCRIPT_NAME'].'?/category/admin/'.$bean->getId().'/'.$bean->getLabel($_SESSION['langue']).'">'.$bean->getLabel($_SESSION['langue']).'</a></div>'."\n";
			$this->content.='	<div class="desc"><a href="'.$_SERVER['SCRIPT_NAME'].'?/category/admin/'.$bean->getId().'/'.$bean->getLabel($_SESSION['langue']).'">'.$bean->getTooltip($_SESSION['langue']).'</a></div>'."\n";
			$this->content.='	<div class="icons">'."\n";
			$this->content.='		<img src="/img/internals/folder.png" title="'.$this->params['translator']->addCat.'" alt="'.$this->params['translator']->addCat.'" onclick="javascript:document.location.href=\''.$_SERVER['SCRIPT_NAME'].'?/category/add/'.$this->params['currentid'].'/\';"/>';
			//if(is_null($bean->getAlternate()) || trim($bean->getAlternate())==''){
				$this->content.='<img src="/img/internals/page.png" title="'.$this->params['translator']->addDoc.'" alt="#?w=40&amp;h=20" class="poplight" name="popup_name"/>';
			//}
			$this->content.='<img src="/img/internals/tool.png" title="'.$this->params['translator']->edit.'" alt="'.$this->params['translator']->edit.'" onclick="javascript:document.location.href=\'/admin.php?/category/edit/'.$bean->getId().'/\';"/><div class="details"><img src="/img/internals/user.png" title="'.$this->params['translator']->owner.'" alt="'.$this->params['translator']->owner.'"/> '.$bean->getOwnerId().' <img src="/img/internals/group.png" title="'.$this->params['translator']->grp.'" alt="'.$this->params['translator']->grp.'"/> '.$bean->getGroupId().' <img src="/img/internals/lock.png" title="'.$this->params['translator']->perm.'" alt="'.$this->params['translator']->perm.'"/><span class="own">'.substr($bean->getPermission(),0,4).'</span><span class="grp">'.substr($bean->getPermission(),4,4).'</span><span class="oth">'.substr($bean->getPermission(),8,4).'</span><img src="/img/internals/created.png" title="'.$this->params['translator']->crDate.'" alt="'.$this->params['translator']->crDate.'"/> '.$bean->getCreated().' <img src="/img/internals/updated.png" title="'.$this->params['translator']->upDate.'" alt="'.$this->params['translator']->upDate.'"/> '.$bean->getUpdated().'</div>'."\n";
			$this->content.='	</div>'."\n";
			
			$this->content.='	<div id="listing">'."\n";
			$alternate = $bean->getAlternate();
			if(is_null($alternate)||trim($alternate)==''){
				foreach ($bean->getChildCategories() as $cat){
					$label = $cat->getLabel($_SESSION['langue']);
					$tooltip = $cat->getTooltip($_SESSION['langue']);
					$this->content.='		<div class="folder">'."\n";
					$this->content.='			<img src="/img/internals/folder.png" title="'.$this->params['translator']->show.'" alt="'.$this->params['translator']->show.'" onclick="javascript:document.location.href=\'/admin.php?/category/admin/'.$cat->getId().'/\';"/><a href="'.$_SERVER['SCRIPT_NAME'].'?/category/admin/'.$cat->getId().'/'.$label.'/" title="'.$tooltip.'" alt="'.$tooltip.'">'.$label.'</a><div class="details"><img src="/img/internals/created.png" title="'.$this->params['translator']->crDate.'" alt="'.$this->params['translator']->crDate.'"/> '.$cat->getCreated().' <img src="/img/internals/updated.png" title="'.$this->params['translator']->upDate.'" alt="'.$this->params['translator']->upDate.'"/> '.$cat->getUpdated().'</div>'."\n";
					$this->content.='		</div>'."\n";
				}
				foreach ($bean->getChildDocuments() as $cat){
					$label = $cat->getLabel($_SESSION['langue']);
					$tooltip = $cat->getTooltip($_SESSION['langue']);
					$this->content.='		<div class="document">'."\n";
					$this->content.='			<img src="/img/internals/page.png" title="'.$this->params['translator']->show.'" alt="'.$this->params['translator']->show.'" onclick="javascript:document.location.href=\'/admin.php?/document/admin/'.$cat->getId().'/\';"/><a href="'.$_SERVER['SCRIPT_NAME'].'?/document/admin/'.$cat->getId().'/'.$label.'/" title="'.$tooltip.'" alt="'.$tooltip.'">'.$label.'</a><div class="details"><img src="/img/internals/created.png" title="'.$this->params['translator']->crDate.'" alt="'.$this->params['translator']->crDate.'"/> '.$cat->getCreated().' <img src="/img/internals/updated.png" title="'.$this->params['translator']->upDate.'" alt="'.$this->params['translator']->upDate.'"/> '.$cat->getUpdated().'</div>'."\n";
					$this->content.='		</div>'."\n";
				}
		
				$this->content.='	</div>'."\n";
			}else{
				$_SESSION['wrapperurl']=$_SERVER['REQUEST_URI'];
				$this->content.='	</div>'."\n";
				$this->content.='<script type="text/javascript">';
				//$this->content.='jQuery.ajaxSetup ({cache: false});var ajax_load = "loading";';
				$this->content.='url = "http://'.$_SERVER['HTTP_HOST'].'/embed.php?'.$alternate.'";';
				$this->content.='ajaxLoad(url,\'listing\',function() {jQuery(\'#dynTab\').dataTable({"oLanguage": {"sUrl": "/js/lang/dynTable_'.strtoupper($_SESSION['langue']).'.txt"}});});';
				//$this->content.='jQuery("#listing").ready(function(){jQuery("#listing").html(ajax_load).load(loadUrl, );});';
				$this->content.='</script>'."\n";
			}
			$this->content.='	<div class="bottomicons">'."\n";
			$this->content.='		<img src="/img/internals/folder.png" title="'.$this->params['translator']->addCat.'" alt="'.$this->params['translator']->addCat.'" onclick="javascript:document.location.href=\''.$_SERVER['SCRIPT_NAME'].'?/category/add/'.$this->params['currentid'].'/\';"/>';
			//if(is_null($bean->getAlternate()) || trim($bean->getAlternate())==''){
				$this->content.='<img src="/img/internals/page.png" title="'.$this->params['translator']->addDoc.'" alt="#?w=40&amp;h=20" class="poplight" name="popup_name"/>';
			//}
			$this->content.='<img src="/img/internals/tool.png" title="'.$this->params['translator']->edit.'" alt="'.$this->params['translator']->edit.'" onclick="javascript:document.location.href=\'/admin.php?/category/edit/'.$bean->getId().'/\';"/>'."\n";
			$this->content.='	</div>'."\n";
	
			$this->content.='</div>'."\n";
			$this->content.='<div id="popup_name" class="popup_block">';
			$selector = new DocumentTypeListGenerator($this->params, $this->Factory);
			$this->content .= $selector->dump();
			$this->content.='</div>';
		}else{
			trigger_error("ERR_LACK_OF_PRIVILEGE", E_USER_ERROR);
		}
	}

	
}

?>