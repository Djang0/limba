<?php
/**
 * @package limba.util
 * @author  Ludovic Reenaers
 * @since 15 déc. 2010
 * @link http://code.google.com/p/limba
 */
class ClassMapHelper{
	private $ClassMap;
	private $cacheExpiration;
	private $cacheFilePath;
	public function __construct(){
		$this->cacheFilePath = PathFactory::getConfigPath().'cache/libs.store';
		$this->cacheExpiration = 60*60;
		$this->ClassMap = $this->loadClassMap();
	}
	
	public function getClassMap(){
		return $this->ClassMap;	
	}
	private function loadClassMap(){
		$map = null;
		if(file_exists($this->cacheFilePath) && (time() - $this->cacheExpiration < filemtime($this->cacheFilePath))){
			$storeContent = file_get_contents($this->cacheFilePath);
  			$map = unserialize($storeContent);
		}else{
			$map = $this->scanServer();
			$ser = serialize($map);
			file_put_contents($this->cacheFilePath, $ser);
		}
		return $map;
	}
	private function scanServer(){
		$map = $this->scanDirectory($_SERVER['DOCUMENT_ROOT']);
		return $map;
	}
	public function getLibPath($libname){
		$pth=null;
		if(array_key_exists($libname, $this->ClassMap)){
			$pth = $this->ClassMap[$libname];

		}
		return $pth;
	}
	private function scanDirectory($dir){
		$map = array();

		if (is_dir($dir)) {

			if ($dh = opendir($dir)) {

				while (($file = readdir($dh)) !== false) {
					$filename=$dir.'/'.$file;
					if($file[0]<>'.' && $file[0]<>'..' && is_file($filename)){
						$tab = explode('.',$file);
						if(isset($tab[1]) && $tab[1]=="php"){
							$map[$tab[0]]= $filename;
						}
					}elseif($file[0]<>'.' && $file[0]<>'..' && (is_dir($filename) || is_link($filename))){
						$map = array_merge($map, $this->scanDirectory($filename));
					}
				}
				closedir($dh);
			}
		}
		return $map;
	}
}
?>