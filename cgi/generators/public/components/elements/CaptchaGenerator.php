<?php
/**
 * @package limba.generators.public.properties
 * @author  Ludovic Reenaers
 * @since 18 juin 2009
 * @link http://code.google.com/p/limba
 */

class CaptchaGenerator extends Generator{
        function setUp(){
                $labels = array('{reloadimg}','{codeinfo}','{code}');
                $values = array($this->params['translator']->reloadimg,$this->params['translator']->codeinfo,$this->params['translator']->code);
                $template = file_get_contents($_SERVER['DOCUMENT_ROOT']."/html/templates/properties/captcha");
                $this->content .=str_replace($labels,$values,$template);
        }
}
?>