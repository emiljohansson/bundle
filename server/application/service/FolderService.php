<?php

class FolderService extends Service {
	public function add() {
		if (!isset($_POST['folderName'])) return;
		$this->webstorage = new Webstorage();
		$path = $this->webstorage->storagePath;
		$folder = $path.$_POST['folderName'];
		if (file_exists($folder)) {
			$this->view->setStatusToError("Folder already exists");
			return;
		}
		mkdir($folder);
	}
}
