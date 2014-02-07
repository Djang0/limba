<?php
/**
 * @package limba.util
 * @author  Ludovic Reenaers
 * @since 21 janv. 2009
 * @link http://code.google.com/p/limba
 */

class Controler
{
	protected $params;
	private $model;
	private $view;
	private $layout;

	function __construct($layout="ERGONOMIC")
	{	
		ErrorOutputer::initialize();
		date_default_timezone_set('Europe/Brussels');
		$this->layout = $layout;
		$pb= new ParamBuilder();
		$this->params = $pb->getParams();
		$this->model = new Model($this->params);
		$this->view = new View($this->model,$this->params,$this->layout);
		$this->checkSession();
		$this->doAction();
		flush();
		print ($this->view->getPage());
		
	}
	private function checkSession(){
		if(!isset($_SESSION["USER_BEAN"])){
			$_SESSION["USER_BEAN"]=$this->model->getAnonymousUser();	
		}
		if (!isset($_SESSION['encoding'])){
			$_SESSION['encoding']='UTF-8';
		}
		if($_SESSION['USER_BEAN']->belongsToGroupLabel('administration')){
			$_SESSION['KCFINDER'] = array();
			$_SESSION['KCFINDER']['disabled'] = false;
		}else{
			$_SESSION['KCFINDER'] = array();
			$_SESSION['KCFINDER']['disabled'] = true;
		}
//		if (!isset($_SESSION['SATAUS'])){
//			$_SESSION['STATUS']=1;
//		}
	}

	function getIP() {
		$ip;
		if (getenv("HTTP_CLIENT_IP"))
		$ip = getenv("HTTP_CLIENT_IP");
		else if(getenv("HTTP_X_FORWARDED_FOR"))
		$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if(getenv("REMOTE_ADDR"))
		$ip = getenv("REMOTE_ADDR");
		else
		$ip = "0.0.0.0";
		return $ip;
	}
	function doAction(){
		$mpack="models/Model".ucfirst($this->params["module"]).".php";
		$vpack="views/View".ucfirst($this->params["module"]).".php";
		$m="Model".ucfirst($this->params["module"]);
		$v="View".ucfirst($this->params["module"]);
		$method=$this->params["action"];
		$bool=true;
		if(file_exists($_SERVER{'DOCUMENT_ROOT'}."/".$mpack) && file_exists($_SERVER{'DOCUMENT_ROOT'}."/".$vpack))
		{
			$this->model=new $m($this->params);
			if($_SESSION['USER_BEAN']->getName() <> 'anonymous'){
				$_SESSION['USER_BEAN']->setIp($this->getIP());
				$this->model->updateUserSecInfo();
			}
			$this->view=new $v($this->model,$this->params,$this->layout);
			if (method_exists($this->view,$method)){
				$this->view->$method($this->model->$method());
			}else{	
				$bool = false;
			}
		}
		else{
			$bool = false;
		}
		if(!$bool){
			$this->view->redirect($_SERVER['SCRIPT_NAME'].'?/homepage/show');
		}
	}
}
?>