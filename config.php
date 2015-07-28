<?php
define("WEB_PATH", "/ozgweb/");
define("UPLOAD_PATH", constant("WEB_PATH") . "upload/");

define("DB_PREFIX", "ozgweb_");

define("WEB_NAME", "ozgweb");
define("WEB_CHARSET", "utf8");

//外链js部分
define("JS_JQUERY", "http://code.jquery.com/jquery-2.1.0.min.js");

//数据库部分
$db_cfg = array(
	//"connect" => "mysql:host=localhost;dbname=ozgweb", //使用mysql
	"connect" => "sqlite:" . $_SERVER["DOCUMENT_ROOT"] . "/ozgweb/ozgweb.php", //使用sqlite
	"user" => "root",
	"pwd" => "root"
);
