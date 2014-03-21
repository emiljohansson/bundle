<?php

class FileService extends Service {
	public function upload() {
		if ($_FILES["file"]["error"] > 0) {
			$this->view->setStatusToError("Error: " . $_FILES["file"]["error"]);
			return;
		}

		$this->webstorage = new Webstorage();
		$filename = $this->webstorage->storagePath."/" . $_FILES["file"]["name"];
		
		if (!move_uploaded_file($_FILES["file"]["tmp_name"], $filename)) {
			$this->view->setStatusToError("Possible file upload attack!");
			return;
		}
	}
}