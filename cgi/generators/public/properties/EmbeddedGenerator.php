<?php
/**
 * @package limba.generators.public.properties
 * @author  Ludovic Reenaers
 * @since 17 mar. 2011
 * @link http://code.google.com/p/limba
 */

class EmbeddedGenerator extends PropertyGenerator{
	protected function getShow(){
		//$strr = '<iframe name="embeddedea" id="embeddede" SRC="/embed.php?'.$this->Property->getValue($_SESSION['langue'])->getValueShort().'" scrolling="no" height="10px" width="100%" FRAMEBORDER="no"></iframe>';
		//$strr = file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/embed.php?'.$this->Property->getValue($_SESSION['langue'])->getValueShort());
		$dao = $this->Factory->getPropertyValueDAO();
		$docid = $this->params['currentid'];
		$proId = $this->Property->getId();
		$value= $dao->getByPropertyByDocumentUsingIds($docid,$proId,$_SESSION['langue']);
		$_SESSION['wrapperurl']=$_SERVER['REQUEST_URI'];
		$strr.='<script type="text/javascript">';
		//$strr.='jQuery.ajaxSetup ({cache: false});';
		$strr.='url = "http://'.$_SERVER['HTTP_HOST'].'/embed.php?'.$value->getValueShort().'";';
		$this->content.='ajaxLoad(url,\'listing\',function() {jQuery(\'#dynTab\').dataTable({"oLanguage": {"sUrl": "/js/lang/dynTable_'.strtoupper($_SESSION['langue']).'.txt"}});});';
		//$strr.='jQuery("#data").ready(function(){jQuery("#data").html(ajax_load).load(loadUrl, function() {jQuery(\'#dynTab\').dataTable({"oLanguage": {"sUrl": "/js/lang/dynTable_'.strtoupper($_SESSION['langue']).'.txt"}});});});';
		$strr.='</script>'."\n";
		
		return $strr;
	}
	protected function getAdd(){
		$this->handleValidation();
		return $this->getAddByIso($_SESSION['langue']);
	}
	protected function getEdit(){
		$this->handleValidation();
		return $this->getEditByIso($_SESSION['langue']);
	}
	protected function getAdmin(){
		return $this->getShow();
	}
	public function getAddByIso($iso){
		return '<tr><td>'.$this->Property->getInfo($iso).' </td><td><input type="text" name="{str}_'.$this->Property->getId().'_'.$iso.'" alt="'.$this->Property->getTooltip($iso).'" title="'.$this->Property->getTooltip($iso).'" /></td></tr>';
	}
	public function getEditByIso($iso){
		$dao = $this->Factory->getPropertyValueDAO();
		$docid = $this->params['currentid'];
		$proId = $this->Property->getId();
		$value= $dao->getByPropertyByDocumentUsingIds($docid,$proId,$iso);
		return '<tr><td>'.$this->Property->getInfo($iso).' </td><td><input type="text" name="{str}_'.$value->getId().'" alt="'.$this->Property->getTooltip($iso).'" title="'.$this->Property->getTooltip($iso).'" value="'.$value->getValueShort().'"/></td></tr>';
	}
}
?>