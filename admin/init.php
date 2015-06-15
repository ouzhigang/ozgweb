<?php
require("../config.php");

//这里的引用来自php.ini的公用include
require("ez_sql/ez_sql_core.php");
require("ez_sql/ez_sql_pdo.php");
require("smarty/Smarty.class.php");

require("../comm/class/SqlText.php");
require("../comm/class/Page.php");
require("../comm/class/FileUtil.php");
require("../comm/class/Encrypt.php");
require("../comm/functions.php");
require("../comm_bll/share.php");

$curr_file_name = strtolower(self());

$db = new ezSQL_pdo($db_cfg["connect"], $db_cfg["user"], $db_cfg["pwd"]);
if(strpos($db_cfg["connect"], "mysql") !== false)
	$db->query("SET NAMES " . constant("WEB_CHARSET"));

define("SMARTY_PATH", "../smarty/");

$smarty = new Smarty();
$smarty->template_dir = "../html/";
$smarty->compile_dir = constant("SMARTY_PATH") . "templates_c/";
$smarty->config_dir = constant("SMARTY_PATH") . "configs/";
$smarty->cache_dir = constant("SMARTY_PATH") . "cache/";

$page = new Page();
$page->pageIndexName = "page";
$page->firstText = "首页";
$page->prevText = "上一页";
$page->nextText = "下一页";
$page->lastText = "末页";

$novalid = array();
$novalid[] = "admin_articlesingle.php";
$novalid[] = "admin_data_add.php";
$novalid[] = "admin_sql.php";
$novalid[] = "msg.php";

//这个数组是为了解决某些不需要SQL验证的页面，如使用了FCK的页面
if(!page_valid()) {
	if(!array_exists($novalid, $curr_file_name)) {
		//msg_box(get_page_valid_msg());
	}
}

session_start();
if($curr_file_name != "index.php") {	
	if(!isset($_SESSION["curr_user"])) {
		header("location:index.php");
	}
}
