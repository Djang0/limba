<?php
/**
 * @package limba.generators.public.components.elements
 * @author  Ludovic Reenaers
 * @since 25 mar. 2011
 * @link http://code.google.com/p/limba
 */
class SlideShowGenerator extends Generator{
	private $speed;
	function __construct($params, $factory,$speed=3000){
		parent::__construct($params, $factory);
		$this->speed = $speed;
	}
	function setUp(){
		$this->content='<form name="slideshow">	<script type="text/javascript">';
		$this->content .='var imgbank = new Array();';
		$this->content .= 'imgbank[0]=["http://www.walloniedesecrivains.be/img/user/petra0.jpg", "", ""];';
		$this->content .= 'imgbank[1]=["http://www.walloniedesecrivains.be/img/user/petra1.jpg", "", ""];';
		$this->content .= 'imgbank[2]=["http://www.walloniedesecrivains.be/img/user/petra2.jpg", "", ""];';
		$this->content .= 'imgbank[3]=["http://www.walloniedesecrivains.be/img/user/petra3.jpg", "", ""];';
		$this->content .= 'imgbank[4]=["http://www.walloniedesecrivains.be/img/user/petra4.jpg", "", ""];';
		$this->content .= 'imgbank[5]=["http://www.walloniedesecrivains.be/img/user/petra5.jpg", "", ""];';
		$this->content .= 'imgbank[6]=["http://www.walloniedesecrivains.be/img/user/petra6.jpg", "", ""];';
		$this->content .= 'imgbank[7]=["http://www.walloniedesecrivains.be/img/user/petra7.jpg", "", ""];';
		$this->content .= 'imgbank[8]=["http://www.walloniedesecrivains.be/img/user/petra8.jpg", "", ""];';
		$this->content .= 'imgbank[9]=["http://www.walloniedesecrivains.be/img/user/petra9.jpg", "", ""];';
		$this->content .= 'imgbank[10]=["http://www.walloniedesecrivains.be/img/user/petra10.jpg", "", ""];';
		$this->content .= 'imgbank[11]=["http://www.walloniedesecrivains.be/img/user/petra11.jpg", "", ""];';
		$this->content .= 'imgbank[12]=["http://www.walloniedesecrivains.be/img/user/petra12.jpg", "", ""];';
		$this->content .='var i =0;';
		$this->content .='var playspeed = 3000;';
		
		
		$this->content.='document.write(\'<img name="imgslide" id="imgslide" src="\'+imgbank[0][0]+\'" border="0">\');';
		$this->content .='initSlide(imgbank,'.$this->speed.');';
		$this->content .='</script></form>';
	}	
}
?>