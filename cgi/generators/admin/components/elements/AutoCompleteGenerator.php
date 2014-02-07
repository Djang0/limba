<?php
/**
 * @package limba.generators.public.components.elements
 * @author  Ludovic Reenaers
 * @since 21 janv. 2009
 * @link http://code.google.com/p/limba
 */

class AutoCompleteGenerator extends Generator{
	function setUp(){
		$this->content ="";
		if(isset($_POST['queryString'])) {
        	$queryString = $_POST['queryString'];
        	$dao = $this->Factory->getDocumentDao();
        	if(strlen($queryString) > 0) {
        		$tab = $dao->getAutoCompleteLookup($queryString);
        		$this->content .= '<ul>';
        		if(sizeof($tab)>0){
            		foreach ($tab as $Doc) {
            			$label = "[".$Doc->getId()."] ".$Doc->getLabel($_SESSION['langue']);
                		$this->content .=<<<EOD
<li onclick="fill('$label');">$label</li>
EOD;
            		}
            		$this->content .= '</ul>';
        		}
			}
		}
	}
}
?>