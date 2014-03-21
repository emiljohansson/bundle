<?php

class HomeController extends Controller {
	
	private $webstorage;

	public function __construct() {
		parent::__construct();
		$this->initWebstorage();
		$this->getFilesForUser();
	}

	public function initView() {
		$this->view = new HomeView();
		$this->view->init();
	}

	private function initWebstorage() {
		$this->webstorage = new Webstorage();
	}

	private function getFilesForUser() {
		$fileHandler = new FileHandler($this->webstorage->storagePath);
		if (count($fileHandler->list) === 0) return;
		foreach ($fileHandler->list as $file) {
			$this->view->addFileRow($file);
		}
	}
}