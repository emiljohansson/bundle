<?php 

class FileController extends Controller {
	
	private $webstorage;

	public function __construct() {
		parent::__construct();
		$this->initWebstorage();
		$this->handleRequest();
		$this->view->setAttribute('style', 'color:black;font-family:sans-serif;');
	}

	private function initWebstorage() {
		$this->webstorage = new Webstorage();
	}

	private function handleRequest() {
		if (isset($_GET['preview'])) {
			$this->renderPreview();
			return;
		}
		if (isset($_GET['remove'])) {
			$this->remove();
			return;
		}
		if (isset($_GET['download'])) {
			$this->download();
			return;
		}
	}

	private function renderPreview() {
		$file = new File($this->webstorage->storagePath.$_GET['preview']);
		$this->handleFile($file);
	}

	private function handleFile(File $file) {
		switch ($file->extension) {
			case 'png':
			case 'gif':
		 	case 'jpg':
		 	case 'jpeg':
				$this->renderImage($file);
				break;
			
			default:
				$this->renderText($file);
				break;
		}
	}

	private function renderImage(File $file) {
		$filename = $file->dirname.'/'.$file->basename;
		header('Content-type: image/png');
		readfile($filename);
	}

	private function renderText(File $file) {
		$filename = $file->dirname.'/'.$file->basename;

		$handle = @fopen($filename, "r");
		$contents = fread($handle, filesize($filename));
		$lines = file($filename, FILE_IGNORE_NEW_LINES);

		fclose($handle);
		foreach ($lines as $key => $line) {
			$str = htmlspecialchars($line);
			$this->view->add(new Label($str));
		}
	}

	private function remove() {
		$file = new File($this->webstorage->storagePath.$_GET['remove']);
		if (file_exists($file->fullpath) === false) {
			$this->view->add(new Label('File does not exist'));
			return;
		}
		if (unlink($file->fullpath)) {
			$this->view->add(new Label($file->basename.' was removed successfully'));
			return;
		}
		$this->view->add(new Label('Error: Was not able to remove file.'));
	}

	private function download() {
		$file = new File($this->webstorage->storagePath.$_GET['download']);
		$this->handleFile($file);
		set_time_limit(0);
		$this->outputFile($file->fullpath, $file->basename, 'text/plain');
		readfile($filename);
	}

	//This application is developed by www.webinfopedia.com
	//visit www.webinfopedia.com for PHP,Mysql,html5 and Designing tutorials for FREE!!!
	private function outputFile($file, $name, $mime_type='') {
		/*
		This function takes a path to a file to output ($file),  the filename that the browser will see ($name) and  the MIME type of the file ($mime_type, optional).
		*/
		
		//Check the file premission
		if(!is_readable($file)) die('File not found or inaccessible!');
		
		$size = filesize($file);
		$name = rawurldecode($name);
		
		/* Figure out the MIME type | Check in array */
		$known_mime_types=array(
			"pdf" => "application/pdf",
			"txt" => "text/plain",
			"html" => "text/html",
			"htm" => "text/html",
			"exe" => "application/octet-stream",
			"zip" => "application/zip",
			"doc" => "application/msword",
			"xls" => "application/vnd.ms-excel",
			"ppt" => "application/vnd.ms-powerpoint",
			"gif" => "image/gif",
			"png" => "image/png",
			"jpeg"=> "image/jpg",
			"jpg" =>  "image/jpg",
			"php" => "text/plain"
		);
		
		if($mime_type==''){
			$file_extension = strtolower(substr(strrchr($file,"."),1));
			if(array_key_exists($file_extension, $known_mime_types)){
				$mime_type=$known_mime_types[$file_extension];
			} else {
				$mime_type="application/force-download";
			};
		};
		
		//turn off output buffering to decrease cpu usage
		@ob_end_clean(); 
		
		// required for IE, otherwise Content-Disposition may be ignored
		if(ini_get('zlib.output_compression'))
		 ini_set('zlib.output_compression', 'Off');
		
		header('Content-Type: ' . $mime_type);
		header('Content-Disposition: attachment; filename="'.$name.'"');
		header("Content-Transfer-Encoding: binary");
		header('Accept-Ranges: bytes');
		
		/* The three lines below basically make the 
		   download non-cacheable */
		header("Cache-control: private");
		header('Pragma: private');
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		
		// multipart-download and download resuming support
		if(isset($_SERVER['HTTP_RANGE']))
		{
			list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
			list($range) = explode(",",$range,2);
			list($range, $range_end) = explode("-", $range);
			$range=intval($range);
			if(!$range_end) {
				$range_end=$size-1;
			} else {
				$range_end=intval($range_end);
			}
			/*
			------------------------------------------------------------------------------------------------------
			//This application is developed by www.webinfopedia.com
			//visit www.webinfopedia.com for PHP,Mysql,html5 and Designing tutorials for FREE!!!
			------------------------------------------------------------------------------------------------------
			*/
			$new_length = $range_end-$range+1;
			header("HTTP/1.1 206 Partial Content");
			header("Content-Length: $new_length");
			header("Content-Range: bytes $range-$range_end/$size");
		} else {
			$new_length=$size;
			header("Content-Length: ".$size);
		}
		
		/* Will output the file itself */
		$chunksize = 1*(1024*1024); //you may want to change this
		$bytes_send = 0;
		if ($file = fopen($file, 'r'))
		{
			if(isset($_SERVER['HTTP_RANGE']))
			fseek($file, $range);
		
			while(!feof($file) && 
				(!connection_aborted()) && 
				($bytes_send<$new_length)
			     )
			{
				$buffer = fread($file, $chunksize);
				print($buffer); //echo($buffer); // can also possible
				flush();
				$bytes_send += strlen($buffer);
			}
		fclose($file);
		} else
		//If no permissiion
		die('Error - can not open file.');
		//die
		die();
	}
}