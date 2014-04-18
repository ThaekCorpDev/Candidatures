<?php 

class Config {

	protected $sourceUrl = "http://localhost/pro/TCORP/CandidTc";


	/**
	*  Setteur Getter pour source url
	**/
	//Getteur
	public function getSourceUrl() {
		return $this->sourceUrl;
	}
	//Setteur
	public function setSourceUrl($source) {
		$this->sourceUrl = $source;
	}

}
