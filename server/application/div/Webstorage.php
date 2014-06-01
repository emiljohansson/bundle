<?php

class Webstorage {
	public $storagePath;

	public function __construct() {
		$this->initLocation();
	}

	private function initLocation() {
		$this->storagePath = substr(SITE_ROOT, 0, strpos(SITE_ROOT, "www/"));
		$this->storagePath.= 'webapps/storage/bundle/'.Auth::getUser()->username.'/';
		if (file_exists($this->storagePath)) return;
		mkdir($this->storagePath, 0777, true);
	}
}
