<?php
/**
 * @package limba.models
 * @author  Ludovic Reenaers
 * @since 20 avril 2011
 * @link http://code.google.com/p/limba
 */
class ModelSitemap extends Model{
	function show(){
		$gen = new SitemapGenerator($this->params,$this->factory);
		return $gen->dump();
	}
}
?>