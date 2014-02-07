<?php
/**
 * @package limba.views
 * @author  Ludovic Reenaers
 * @since 20 oct. 2010
 * @link http://code.google.com/p/limba
 */


class ViewUser extends View{
	function password($url){
		$this->redirect($url);
	}
	function reset($generator){
		if (!is_null($generator)&& is_a($generator, 'Generator')){
			$this->setContent($generator->dump());
		}else{
			$this->redirect($_SERVER['SCRIPT_NAME'].'?/homepage/show/');
		}
	}
	function insert($str){
		FormManager::redirectGood();
	}
	function update($str){
		FormManager::redirectGood();
	}
	function add($generator){
		$this->setContent($generator->dump());
	}
	function edit($generator){
		$this->setContent($generator->dump());
	}
	function authenticate($bool){
		if($bool){
			if(isset($_SESSION['backUrl'])){
				$tmp = $_SESSION['backUrl'];
				unset($_SESSION['backUrl']);
				$this->redirect($tmp);
			}else{
				$this->redirect($_SERVER['SCRIPT_NAME']."?/homepage/show/");
			}
		}else{
			$this->redirect($_SERVER['SCRIPT_NAME']."?/login/show/");
		}

	}
	function logout($bool){
		$this->redirect($_SERVER['SCRIPT_NAME']."?/homepage/show/");
	}
}
?>