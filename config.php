<?php
define("WEB_PATH", "/ozgweb/");
define("UPLOAD_PATH", constant("WEB_PATH") . "upload/");

define("WEB_NAME", "ozgweb");
define("WEBPATH_ADMIN", "admin"); //后台目录
define("SB_ADMIN_2_PATH", "startbootstrap-sb-admin-2-1.0.7"); //sb-admin-2的目录

//数据库部分
$db_cfg = array(
	//"connect" => "mysql:host=localhost;dbname=ozgweb", //使用mysql
	"connect" => "sqlite:" . $_SERVER["DOCUMENT_ROOT"] . "/ozgweb/ozgweb.php", //使用sqlite
	"user" => "root",
	"pwd" => "root"
);
