<?php

class FileHandler {

	public $files = array();
	public $folders = array();

	public function __construct($directory) {
		if (!file_exists($directory)) return;
		$result = $this->findAllFiles($directory);
		$this->populateList($result);
	}

	private function findAllFiles($directory) {
		$root = scandir($directory);
		$result = array(
			"files" => array(),
			"folders" => array()
		);
		foreach($root as $value) {
			if($value === '.' || $value === '..' || $value === '.DS_Store') {
				continue;
			}
			if(is_file("$directory/$value")) {
				$result['files'][] = "$directory/$value";
				continue;
			}
			if (is_dir("$directory/$value")) {
				$result['folders'][] = "$directory/$value";
				continue;
			}
		}
		return $result;
	}

	private function populateList(array $result) {
		foreach ($result['files'] as $path) {
			$file = new File($path);
			$this->files[] = $file;
		}
		foreach ($result['folders'] as $path) {
			$folder = new Folder($path);
			$this->folders[] = $folder;
		}
	}
}
