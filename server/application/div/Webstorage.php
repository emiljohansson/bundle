<?php

class Webstorage {
	public $storagePath;
	public $localPath;

	public function __construct() {
		$this->initLocal();
		$this->initLocation();
	}

	private function initLocation() {
		$this->storagePath = substr(SITE_ROOT, 0, strpos(SITE_ROOT, "www/"));
		$this->storagePath.= 'webapps/storage/bundle/'.Auth::getUser()->username.'/'.$this->localPath;
		if (file_exists($this->storagePath)) return;
		mkdir($this->storagePath, 0777, true);
	}

	private function initLocal() {
		$this->localPath = isset($_GET['folder']) ? $_GET['folder'] : "";
	}
}
