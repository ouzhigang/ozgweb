<?php
define("WEB_PATH", "/ozgweb/");
define("UPLOAD_PATH", constant("WEB_PATH") . "upload/");

define("PDO_CONNECT", "sqlite:" . $_SERVER["DOCUMENT_ROOT"] . "/ozgweb/ozgweb.php");

define("DB_PREFIX", "ozgweb_");

define("WEB_NAME", "ozgweb");
define("WEB_CHARSET", "utf-8");

//外链js部分

define("JS_JQUERY", "http://code.jquery.com/jquery-2.1.0.min.js");

