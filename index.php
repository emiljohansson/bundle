<?php
ini_set('display_errors', 1);
define('SITE_ROOT', realpath(dirname(__FILE__)).'/');
define('SERVER_ROOT', substr(SITE_ROOT, 0, strpos(SITE_ROOT, "www/")));
$APPLICATION_NAME = 'bundle';
$PATH_TO_LIBRARY = $_SERVER['DOCUMENT_ROOT'].'/com/github/phplibrary/se/emiljohansson/lib/';
require_once SERVER_ROOT.'webapps/config/'.$APPLICATION_NAME.'/Config.php';
require_once $PATH_TO_LIBRARY.'util/autoloader.php';
addDefaultRootPath($PATH_TO_LIBRARY);
new Main();
