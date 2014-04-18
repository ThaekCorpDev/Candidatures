<?php 

class Html {

	//SourceUrl
	protected $sUrl;

	public function __construct($sourceUrl) {
		$this->sUrl = $sourceUrl;
	}

	/**
	*  Permet de charger css/javascript ($href = Nom, $type = le type)
	**/
	public function load($href = false, $type = "css") {
		if(!$href) {
			return false;
		}
		if($type = "css") {
			return '<link rel="stylesheet" href="'.$this->sUrl.'/Css/'.$href.'.css" />';
		}
	}

}

 ?>