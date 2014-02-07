<?php
/**
 * @package limba.generators.public.components.forms
 * @author  Ludovic Reenaers
 * @since 26 oct. 2010
 * @link http://code.google.com/p/limba
 */

class UserFormGenerator extends FormGenerator{
	function setUp(){	
		if($_SESSION['USER_BEAN']->getName()=='anonymous' || $this->params["action"]=="add"){
			$name = "";
			$surname = "";
			$email = "";
			$rue = "";
			$num = "";
			$city = "";
			$zip = "";
			$country = "";
			$ddn = "";
			$url = $_SERVER['SCRIPT_NAME']."?/user/insert/";
			$updtBut=$this->params['translator']->userAdd;
		}elseif ($this->params["action"]=="edit") {
			$updtBut=$this->params['translator']->userEdit;
			$name = $_SESSION['USER_BEAN']->getName();
			$surname = $_SESSION['USER_BEAN']->getSurname();
			$email = $_SESSION['USER_BEAN']->getEmail();
			$rue = $_SESSION['USER_BEAN']->getStreet();
			$num = $_SESSION['USER_BEAN']->getNumber();
			$city = $_SESSION['USER_BEAN']->getCity();
			$zip = $_SESSION['USER_BEAN']->getZip();
			$country = $_SESSION['USER_BEAN']->getCountry();
			$url =$_SERVER['SCRIPT_NAME']."?/user/update/";
			list($year,$month,$day)=preg_split('/[-\.\/ ]/',$_SESSION['USER_BEAN']->getDdn());
			$ddn = $day."/".$month."/".$year;
		}
		$lngGen = new LngListGenerator($this->params,$this->Factory);
		$lng = $lngGen->dump();	  
		$labels = array('{updtbutton}','{encoding}','{ERROR-HERE}','{labelNom}','{nomValue}','{nominfo}','{url}');
		$labels2 = array('{labelprenom}','{prenomvalue}','{prenominfo}', '{labelemail}','{emailvalue}','{emailinfo}');
		$labels3 = array('{labelrue}','{ruevalue}','{rueinfo}', '{labelnumero}','{numerovalue}','{numeroinfo}');
		$labels4 = array('{labelcity}','{cityvalue}','{cityinfo}', '{labelzip}','{zipvalue}','{zipinfo}');
		$labels5 = array('{labelcountry}','{countryvalue}','{countryinfo}', '{labelddn}','{ddnvalue}','{ddninfo}');
		$labels6 = array('{labellng}','{lnglist}','{labelPws}','{pwsinfo}','{labelPws2}','{pws2info}','{title}');	  
		$values = array($updtBut,$_SESSION['encoding'],'',$this->params['translator']->labelNom,$name,$this->params['translator']->nomInfo,$url);
		$values2 = array($this->params['translator']->labelPrenom,$surname,$this->params['translator']->prenomInfo,$this->params['translator']->labelEmail,$email,$this->params['translator']->emailInfo);
		$values3 = array($this->params['translator']->labelRue,$rue,$this->params['translator']->rueInfo,$this->params['translator']->labelNumero, $num, $this->params['translator']->numeroInfo);
		$values4 = array($this->params['translator']->labelCity,$city,$this->params['translator']->cityInfo,$this->params['translator']->labelZip,$zip,$this->params['translator']->zipInfo);
		$values5 = array($this->params['translator']->labelCountry,$country,$this->params['translator']->countryInfo,$this->params['translator']->labelDDN,$ddn,$this->params['translator']->ddnInfo);
		$values6 = array($this->params['translator']->labelLng,$lng,$this->params['translator']->labelPws,$this->params['translator']->pwsinfo,$this->params['translator']->labelPws2,$this->params['translator']->pws2info, $this->params["title"]);
		$template = file_get_contents("html/templates/forms/userEdit");
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