<?php
/**
 * @package limba.interfaces
 * @since 21 janv. 2009
 * @author  Ludovic Reenaers
 * @link http://code.google.com/p/limba
 */
class View
{
	private $Model;
	private $doctype;
	private $head;
	private $title;
	private $content;
	private $footer;
	private $html;
	private $MenuTree;
	private $header;
	private $pathway;
	private $languagePad;
	private $userPad;
	private $wlkm;
	protected $params;

	function __construct($Model,$params,$layout="ERGONOMIC",$doctype="XHTML1.0T",$headertype="BASE")
	{
		$this->params = $params;
		$this->Model =$Model;
	}

	function setContent($str)
	{
		$this->content.=$str;
	}
	function redirect($url){
		$this->setContent('<META HTTP-EQUIV="Refresh" CONTENT="0; URL='.$url.'">');
	}
	function getPage()
	{

		$ret = $this->Model->getData();
		$ret=str_replace("CONTENT",$this->content,$ret);
		return $ret;
	}

}
?>