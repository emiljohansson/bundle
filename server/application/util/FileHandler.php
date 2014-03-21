<?php

class FileHandler {

	public $list = array();

	public function __construct($directory) {
		if (!file_exists($directory)) return;
		$result = $this->findAllFiles($directory);
		$this->populateList($result);
	}

	private function findAllFiles($directory) {
		$root	= scandir($directory);
		$result	= array();
		foreach($root as $value) { 
			if($value === '.' || $value === '..' || $value === '.DS_Store') {
				continue;
			} 
			if(is_file("$directory/$value")) {
				$result[] = "$directory/$value";
				continue;
			}
			foreach(find_all_files("$directory/$value") as $value) {
				$result[]=$value;
			}
		}
	    return $result;
	}

	private function populateList(array $result) {
		foreach ($result as $path) {
			$file = new File($path);
			$this->list[] = $file;
		}
	}
}