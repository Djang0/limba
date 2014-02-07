<?php
/**
 * @package limba.models
 * @author  Ludovic Reenaers
 * @since 11 mar. 2011
 * @link http://code.google.com/p/limba
 */

class ModelContact extends Model{
	function add(){
		FormManager::setUrls($_SERVER['SCRIPT_NAME']."?/contact/done/","http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		$factory  = new DocumentFactory($this->params,$this->factory,'USR');
		return $factory;
	}
	function done(){
		return $this->params['translator']->ctcDone;
	}
	function insert(){
		$DAO = $this->factory->getDocumentDAO();
		$typeDocDAO = $this->factory->getTypeDocumentDAO();
		$propDAO = $this->factory->getPropertyDAO();
		$catDAO =  $this->factory->getCategoryDAO();
		$langDAO = $this->factory->getLangueDAO();
		$docInfoDAO = $this->factory->getDocumentInfoDAO();
		$valDAO = $this->factory->getPropertyValueDAO();
		$langs = $langDAO->getAllAvailable();
		$Cat = $catDAO->getById((int)$_POST['targetcatid']);
		$Document = new Document(0);
		$Document->setOwnerId((int)$_SESSION['USER_BEAN']->getId());
		$Document->setGroupId($Cat->getGroupId());
		$Document->setPermission($Cat->getPermission());
		$Document->setParentCategoryId((int)$_POST['targetcatid']);
	
		$typeDoc = $typeDocDAO->getById((int)$_POST['typedocid']);
		$Document->setTypeDocument($typeDoc);
		//$Document = $DAO->add($Document);
		$proptab = array();
		$meta = time();
		$infos = array();
		foreach ($langs as $Lng){
			$DocInfo = new DocumentInfo(0);
			$DocInfo->setDocumentId($Document->getId());
			$DocInfo->setLangue($Lng);
			$DocInfo->setLabel($meta);
			$DocInfo->setTooltip('User request @ '.$meta);
			array_push($infos,$DocInfo);
			//$DocInfo = $docInfoDAO->add($DocInfo);
		}
		
		$values=array();
		foreach($_POST as $key=>$val){
			$tab = explode("_",$key);
			foreach ($langs as $lng){
				$Val=null;
				if ($tab[0] == "{str}"){
					$Val=$this->buildValueObject($val, $tab, $proptab,$Document,$lng);
				}elseif ($tab[0] == "{xpe}"){
					if (isset($_POST["{chk}_".$tab[1]."_".$tab[2]])){
						$bool = 1;
					}else{
						$bool =0;
					}
					$Val=$this->buildValueObject($bool, $tab, $proptab,$Document,$lng);
				}elseif ($tab[0] == "{dfr}"){
					$interv = array();
					array_push($interv, $val, $_POST["{dto}_".$tab[1]."_".$tab[2]]);
					$Val=$this->buildValueObject($interv, $tab, $proptab,$Document,$lng);
				}
				if(!is_null($Val)){
					array_push($values,$Val);
				}
			}
		}
		$Document->setInfos($infos);
		$Document->setValues($values);
		$Document = $DAO->add($Document);
		$to  = (string)$this->params['config']->info;
		$subject = $this->params['translator']->CTC_MAIL_SUBJECT;
		$message = '<html><head></head><body>'.$this->params['translator']->CTC_MAIL_NUMBERIS.$meta.' '.$this->params['translator']->CTC_MAIL_CHECKON.'<a href="'.(string)$this->params['config']->siteurl.'/admin.php?/document/show/'.$Document->getId().'/'.$meta.'/">'.$this->params['translator']->site.'</a>.<br/></body></html>';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8'."\r\n";
		$headers .= 'To: Administrateur <'.(string)$this->params['config']->info.'>' . "\r\n";
		$headers .= 'From: User <'.(string)$this->params['config']->noreply.'>' . "\r\n";
		mail($to, $subject, $message, $headers);
		return "";
	}
	//TODO: move buildValueObject and getTabItemById as it is used in multiple models
	private function buildValueObject($theval,$tab,$proptab,$Document,$lng){
			$prop = $this->getTabItemById($proptab, (int)$tab[1]);
			$propDAO = $this->factory->getPropertyDAO();
			$value = null;
			if(is_null($prop)){
				$prop = $propDAO->getById($tab[1]);
				array_push($proptab, $prop);
			}
			if(FormManager::validateProperty((int)$tab[1],$theval)){
				$value = new PropertyValue(0);
				$value->setPropertyId((int)$tab[1]);
				$value->setLangue($lng);
				$value->setDocumentId($Document->getId());
				$meth = "set".$prop->getTypeProperty()->getMethod();
				$value->$meth($theval);
				//$value=$valDAO->add($value);	
			}else{
				trigger_error("ERR_BAD_FORMAT", E_USER_ERROR);
			}
			return $value;
			
	}
	private function getTabItemById($tab,$id){
		$item =null;
		foreach ($tab as $TabItem){
			if($TabItem->getId()==$id){
				$item = $TabItem;
			}
		}
		return $item;
	}
}