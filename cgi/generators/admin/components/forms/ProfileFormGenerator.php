<?php
/**
 * @package limba.generators.admin.components.forms
 * @author  Ludovic Reenaers
 * @since 20 mai 2011
 * @link http://code.google.com/p/limba
 */

class ProfileFormGenerator extends FormGenerator{
	function setUp(){
		$template = file_get_contents("html/templates/forms/profileForm");
		
		$profDAO = $this->Factory->getProfileDAO();
		$tokDAO = $this->Factory->getTokenDAO();
		if($this->params['action']=='edit'){
			$prof = $profDAO->getById((int)$this->params['profid']);
			$updtBut=$this->params['translator']->userEdit;
			$url =$_SERVER['SCRIPT_NAME']."?/profile/update/";
			$id=$prof->getId();
			$comment = $prof->getComment();
			$label = $prof->getLabel();
			$toopts = "";
			$toopttab = array();
			foreach ($prof->getTokens() as $tok){
				$toopts .= '<option value="'.$tok->getId().'">'.$tok->getLabel().'</option>'."\n";
			  	array_push($toopttab, $tok->getId());
			}
		}else{
			$updtBut=$this->params['translator']->userAdd;
			$id=0;
			$toopts = "";
			$toopttab = array();
			$url =$_SERVER['SCRIPT_NAME']."?/profile/insert/";
			$comment ='';
			$label = '';
		}
		$fromopts ="";
	  	foreach ($tokDAO->getAll() as $tok){
	  		if(!in_array($tok->getId(), $toopttab)){
	  			$fromopts .= '<option value="'.$tok->getId().'">'.$tok->getLabel().'</option>'."\n";
	  		}
	  	}
		$labels = array('{updtbutton}','{encoding}','{url}','{profid}','{commentvalue}','{profNameValue}','{labelProfile}','{profinfo}', '{profComment}','{commentinfo}','{tokAvaible}','{currenttok}','{tooptions}','{fromoptions}');
		$values = array($updtBut,$_SESSION['encoding'],$url,$id,$comment,$label,$this->params['translator']->labelProfile ,$this->params['translator']->profInfo,$this->params['translator']->profComm,$this->params['translator']->commInfo,$this->params['translator']->tokAvail,$this->params['translator']->tokCurr,$toopts,$fromopts);
		$template = str_replace($labels,$values,$template);
		$this->content .= $template;
		$wraped = "";
		foreach ($this->children as $child){
			$wraped.=$child->dump();
		}
		$this->content = str_replace("{WRAP-HERE}",$wraped,$this->content);
	}
}
?>