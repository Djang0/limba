<?php
/**
 * @package limba.generators.admin.components.elements
 * @author  Ludovic Reenaers
 * @since 22 fev. 2011
 * @link http://code.google.com/p/limba
 */

class DocumentTypeListGenerator extends Generator{
	function setUp(){
		$this->content ="";
		$docTypDAO = $this->Factory->getTypeDocumentDAO();
		$docList = $docTypDAO->getAll();
		$act= $this->params["action"];
		$this->content .= '<div id="selector"><h1>'.$this->params['translator']->selTypeDoc.'</h1>';
		$this->content .= '<select name="typeid" id="typeId">'."\n";
		foreach ($docList as $Doctyp){
			$this->content .= '<option value="'.$Doctyp->getId().'">';
			$this->content .= $Doctyp->getLabel();
			$this->content .= '</option>';
		}
		$this->content .= '</select>'."\n";
		$this->content .= '		<br/><input type="button" value="'.$this->params['translator']->select.'" onclick="redirectToAddDocument(\''.$_SERVER['SCRIPT_NAME'].'\',\''.$this->params['currentid'].'\',\'typeId\');"/></div>'."\n";
	}
}