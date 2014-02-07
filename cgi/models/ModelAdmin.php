<?php
/**
 * @package limba.models
 * @author  Ludovic Reenaers
 * @since 02 mar. 2011
 * @link http://code.google.com/p/limba
 */

class ModelAdmin extends Model{
	function useredit(){
		//FormManager::setFallBackUrl($_SERVER['SCRIPT_NAME']."?/security/admin/");
		FormManager::setUrls($_SERVER['SCRIPT_NAME']."?/security/admin/","http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		$generator = new AdminUserFormGenerator($this->params, $this->factory);
		return $generator;
	}
	function userAdd(){
		
		FormManager::setUrls($_SERVER['SCRIPT_NAME']."?/security/admin/","http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		$generator = new AdminUserFormGenerator($this->params, $this->factory);
		return $generator;
	}
	function userupdate(){
		$usrDao = $this->factory->getUserDAO();
		$grpDAO = $this->factory->getGroupDAO();
		$usr = $usrDao->getById((int)$_POST['targetusrid']);
		$usr->setName($_POST['nom']);
		$usr->setSurname($_POST['prenom']);
		$usr->setEmail($_POST['email']);
		$usr->setStreet($_POST['rue']);
		$usr->setNumber($_POST['numero']);
		$usr->setZip($_POST['zip']);
		$usr->setCity($_POST['city']);
		$usr->setCountry($_POST['country']);
		$lngDAO = $this->factory->getLangueDAO();
		$usr->setLangue($lngDAO->getById($_POST['lng']));
		list($day,$month,$year)=preg_split('/[-\.\/ ]/',$_POST['ddn']);
		$usr->setDdn($day,$month,$year);
		$grpDAO->removeByUser($usr);
		foreach ($_POST['too'] as $key=>$value){
			$grpDAO->add($usr->getId(),$value);
		}
		$bool = $usrDao->update($usr);
		if(!$bool){
			trigger_error("ERR_FAILED_UPDATE", E_USER_ERROR);
		}
		return "done!";
	}
	function userinsert(){
		$usrDao = $this->factory->getUserDAO();
		$grpDAO = $this->factory->getGroupDAO();
		$usr = new User(0);
		$usr->setName($_POST['nom']);
		$usr->setSurname($_POST['prenom']);
		$usr->setEmail($_POST['email']);
		$usr->setStreet($_POST['rue']);
		$usr->setNumber($_POST['numero']);
		$usr->setZip($_POST['zip']);
		$usr->setCity($_POST['city']);
		$usr->setCountry($_POST['country']);
		$usr->setPwsHash(md5($_POST['pws']), md5($_POST['pws']));
		$lngDAO = $this->factory->getLangueDAO();
		$usr->setLangue($lngDAO->getById($_POST['lng']));
		list($day,$month,$year)=preg_split('/[-\.\/ ]/',$_POST['ddn']);
		$usr->setDdn($day,$month,$year);
		$usr = $usrDao->add($usr);
		foreach ($_POST['too'] as $key=>$value){
			$grpDAO->add($usr->getId(),$value);
		}
		return "done";
	}
}
?>