<?php

class File {
	public $type = 'file';
	public $fullpath;

	public function __construct($path) {
		$info = pathinfo($path);
		foreach ($info as $key => $value) {
			$this->$key = $value;
		}
		$this->fullpath = $this->dirname.'/'.$this->basename;
	}
}
