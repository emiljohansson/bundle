<?php

class FolderController extends FileController {
	protected function remove() {
		$file = new Folder($this->webstorage->storagePath.$_GET['remove']);
		console::log($file->fullpath);
		if (file_exists($file->fullpath) === false) {
			$this->view->add(new Label('File does not exist'));
			return;
		}
		if (rmdir($file->fullpath)) {
			$this->view->add(new Label($file->basename.' was removed successfully'));
			return;
		}
		$this->view->add(new Label('Error: Was not able to remove folder.'));
	}
}
