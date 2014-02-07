<?php
/**
 * @package limba.generators.public.components.elements
 * @author  Ludovic Reenaers
 * @since 5 avr. 2011
 * @link http://code.google.com/p/limba
 */

class NotifyGenerator extends Generator{
	function setUp()
	{
		if(isset($_SESSION['errBool']) && $_SESSION['errBool']){
			$this->content ='<div class="notify">	<div class="up"></div> <div class="cnt"><ul>';
			$errTab=ErrorOutputer::getOutput();
			foreach( $errTab['err'] as $errStr){
				
				$errDump = $this->params['translator']->$errStr;
				if($errDump =='NULL!!'){
					$errDump = "No translation for :".$errStr;
				}
				$this->content .= '<li><span class="typeErr">'.$this->params['translator']->err.'</span>: '.$errDump.'</li>';
			}
			foreach( $errTab['warn'] as $errStr){
				$this->content .= '<li><span class="typeErr">'.$this->params['translator']->warn.'</span>: '.$errStr.'</li>';
			}
			foreach( $errTab['note'] as $errStr){
				$this->content .= '<li><span class="typeErr">'.$this->params['translator']->note.'</span>: '.$errStr.'</li>';
			}
			foreach( $errTab['uknw'] as $errStr){
				$this->content .= '<li><span class="typeErr">'.$this->params['translator']->uknw.'</span>: '.$errStr.'</li>';
			}
			foreach( $errTab['except'] as $errStr){
				$this->content .= '<li><span class="typeErr">'.$this->params['translator']->except.'</span>: '.$errStr.'</li>';
			}
			$this->content.='</ul></div> <div class="dwn"></div></div>';
		}else{
			$this->content = '';
		}
	}
}
?>
