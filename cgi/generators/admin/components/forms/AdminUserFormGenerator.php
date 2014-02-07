<?php
/**
 * @package limba.generators.admin.components.forms
 * @author  Ludovic Reenaers
 * @since 26 oct. 2010
 * @link http://code.google.com/p/limba
 */

class AdminUserFormGenerator extends FormGenerator{
	function setUp(){
		$template = file_get_contents("html/templates/forms/adminUserEdit");
		$usrDAO = $this->Factory->getUserDAO();
		$profDAO = $this->Factory->getProfileDAO();
		if($this->params['action']=='useredit'){
	  		$usr = $usrDAO->getById((int)$this->params['targetusrid']);
	  		$toopttab = array();
	  		$toopts = "";
			foreach ($usr->getGroups() as $grp){
				$toopts .= '<option value="'.$grp->getId().'">'.$grp->getLabel().'</option>'."\n";
			  	array_push($toopttab, $grp->getId());
			}
			$id= $usr->getId();
		  	$updtBut=$this->params['translator']->userEdit;
			$name = $usr->getName();
			$surname = $usr->getSurname();
			$email = $usr->getEmail();
			$rue = $usr->getStreet();
			$num = $usr->getNumber();
			$city = $usr->getCity();
			$zip = $usr->getZip();
			$country = $usr->getCountry();
			$url =$_SERVER['SCRIPT_NAME']."?/admin/userupdate/";
			list($year,$month,$day)=preg_split('/[-\.\/ ]/',$usr->getDdn());
			$ddn = $day."/".$month."/".$year;
			$pwsBlock = "";
		}else{
	  		$updtBut=$this->params['translator']->userAdd;
	  		$url =$_SERVER['SCRIPT_NAME']."?/admin/userinsert/";
	  		$toopttab = array();
	  		$toopts = "";
	  		$id=0;
	  		$name = "";
			$surname = "";
			$email = "";
			$rue = "";
			$num = "";
			$city = "";
			$zip = "";
			$country = "";
			$ddn = " ";
			$pwsBlock = '<tr class="userFormTr">'."\n";
			$pwsBlock .= '	<th class="userFormTh">'."\n";
			$pwsBlock .= '		'.$this->params['translator']->labelPws."\n";
			$pwsBlock .= '	</th>'."\n";
			$pwsBlock .= '	<td class="userFormTd">'."\n";
			$pwsBlock .= '		<input value="" type="PASSWORD" name="pws" title="'.$this->params['translator']->pwsinfo.'" alt="'.$this->params['translator']->pwsinfo.'">'."\n";
			$pwsBlock .= '	</td>'."\n";
			$pwsBlock .= '</tr>'."\n";
		}
		$lngGen = new LngListGenerator($this->params,$this->Factory);
		$lng = $lngGen->dump();
	  	$fromopts ="";
	  	foreach ($profDAO->getAll() as $prof){
	  		if(!in_array($prof->getId(), $toopttab)){
	  			$fromopts .= '<option value="'.$prof->getId().'">'.$prof->getLabel().'</option>'."\n";
	  		}
	  	}
		$labels = array('{updtbutton}','{encoding}','{labelNom}','{nomValue}','{nominfo}','{url}');
		$labels2 = array('{labelprenom}','{prenomvalue}','{prenominfo}', '{labelemail}','{emailvalue}','{emailinfo}');
		$labels3 = array('{labelrue}','{ruevalue}','{rueinfo}', '{labelnumero}','{numerovalue}','{numeroinfo}');
		$labels4 = array('{labelcity}','{cityvalue}','{cityinfo}', '{labelzip}','{zipvalue}','{zipinfo}');
		$labels5 = array('{labelcountry}','{countryvalue}','{countryinfo}', '{labelddn}','{ddnvalue}','{ddninfo}');
		$labels6 = array('{labellng}','{lnglist}','{targetusrid}','{fromoptions}','{tooptions}','{pwsblock}','{profAvaible}','{currentProfs}');
		$values = array($updtBut,$_SESSION['encoding'],$this->params['translator']->labelNom,$name,$this->params['translator']->nomInfo,$url);
		$values2 = array($this->params['translator']->labelPrenom,$surname,$this->params['translator']->prenomInfo,$this->params['translator']->labelEmail,$email,$this->params['translator']->emailInfo);
		$values3 = array($this->params['translator']->labelRue,$rue,$this->params['translator']->rueInfo,$this->params['translator']->labelNumero, $num, $this->params['translator']->numeroInfo);
		$values4 = array($this->params['translator']->labelCity,$city,$this->params['translator']->cityInfo,$this->params['translator']->labelZip,$zip,$this->params['translator']->zipInfo);
		$values5 = array($this->params['translator']->labelCountry,$country,$this->params['translator']->countryInfo,$this->params['translator']->labelDDN,$ddn,$this->params['translator']->ddnInfo);
		$values6 = array($this->params['translator']->labelLng,$lng,$id,$fromopts,$toopts,$pwsBlock,$this->params['translator']->profAvaible,$this->params['translator']->currentProfs);
		$template = str_replace($labels,$values,$template);
		$template = str_replace($labels2,$values2,$template);
		$template = str_replace($labels3,$values3,$template);
		$template = str_replace($labels4,$values4,$template);
		$template = str_replace($labels5,$values5,$template);
		$template = str_replace($labels6,$values6,$template);	
		$this->content .= $template;
		$wraped = "";
		foreach ($this->children as $child){
			$wraped.=$child->dump();
		}
		$this->content = str_replace("{WRAP-HERE}",$wraped,$this->content);
	}
}
?>