<?php

class FolderService extends Service {
	public function add() {
		if (!isset($_POST['folderName'])) return;

		$path = "";
		if (isset($_POST['path'])) {
			$path = $_POST['path'];
		}
		else {
			$webstorage = new Webstorage();
			$path = $webstorage->storagePath;
		}
		$folder = $path.'/'.$_POST['folderName'];
		if (file_exists($folder)) {
			$this->view->setStatusToError("Folder already exists");
			return;
		}
		mkdir($folder);
	}
}
