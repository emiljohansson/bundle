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
		if (count($fileHandler->folders) > 0) {
			foreach ($fileHandler->folders as $folder) {
				$this->view->addFolderRow($folder);
			}
		}
		if (count($fileHandler->files) > 0) {
			foreach ($fileHandler->files as $file) {
				$this->view->addFileRow($file);
			}
		}
	}
}
