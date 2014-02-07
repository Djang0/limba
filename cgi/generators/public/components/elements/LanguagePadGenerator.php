<?php
/**
 * @package limba.generators.public.components.elements
 * @author  Ludovic Reenaers
 * @since 30 sep. 2010
 * @link http://code.google.com/p/limba
 */

class LanguagePadGenerator extends Generator{
	protected function setUp(){
		$DAO = $this->Factory->getLangueDAO();
		$this->content = '<div id="languages"><ul>';
		$LngTab = $DAO->getAllAvailable();
		$origUrl = str_replace("/","{{-}", substr($_SERVER["REQUEST_URI"],strlen($_SERVER["SCRIPT_NAME"])+1));
		foreach ($LngTab as $lng){
			$this->content .= "<li>";
			$info = $lng->getIso();
			if ($info == $_SESSION['langue']){
				$this->content .= '<span class="active">'.strtolower($info).'</span>';
			}else{				
				$this->content .= '<a href="'.$_SERVER['SCRIPT_NAME'].'?/language/change/'.$info.'/'.$origUrl.'" title="'.$lng->getLabel($info).'" alt="'.$lng->getLabel($info).'">'.strtolower($info).'</a>';
			}
			$this->content .= "</li>";
		}
		$this->content .= "</ul></div>";
	}
}
?>