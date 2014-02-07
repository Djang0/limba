<?php
/**
 * @package limba.generators.public.components.elements
 * @author  Ludovic Reenaers
 * @since 1 fevr. 2011
 * @link http://code.google.com/p/limba
 */
class WelcomeTabGenerator extends Generator {
	public function setUp(){
		if($this->params["module"] == "homepage"){
			$this->content = '<div id="onglet"><ol id="toc">';
			$this->content .= '<li><a href="#page-individuels"><span>Individuels-Familles</span></a></li>';
			$this->content .= '<li><a href="#page-groupes"><span>Groupes</span></a></li>';
			$this->content .= "</ol>";
			$this->content .= '<div class="subcontent" id="page-individuels">';
			$this->content .= "Contenu de l'onglet individuels";
			$this->content .= '</div>';
			$this->content .= '<div class="subcontent" id="page-groupes">';
			$this->content .= "Contenu de l'onglet Groupes";
			$this->content .= '</div>';
			$this->content .= '</div>';
			$template ='<script src="/js/ext/activatables.js" type="text/javascript"></script>';
			$template.='<script type="text/javascript">';
			$template.="activatables('page', ['page-individuels','page-groupes']);</script>";
			$this->content .= $template;
		}
	}
}
?>