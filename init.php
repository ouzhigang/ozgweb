<?php
require("config.php");
require("comm/class/ez_sql/ez_sql_core.php");
require("comm/class/ez_sql/ez_sql_pdo.php");
require("comm/class/SqlText.class.php");
require("comm/class/Page.class.php");
require("comm/class/runtime.class.php");
require("comm/class/FileUtil.class.php");
require("comm/class/smarty/Smarty.class.php");
require("comm/class/Snoopy.class.php");
require("comm/functions.php");

$curr_file_name = strtolower(self());

$runtime = new runtime();

$db = new ezSQL_pdo($db_cfg["connect"], $db_cfg["user"], $db_cfg["pwd"]);
if(strpos($db_cfg["connect"], "mysql") !== false)
	$db->query("SET NAMES " . constant("WEB_CHARSET"));

define("SMARTY_PATH", "smarty/");

$smarty = new Smarty();
$smarty->template_dir = constant("WEB_PATH") . "html/";
$smarty->compile_dir = constant("SMARTY_PATH") . "templates_c/";
$smarty->config_dir = constant("SMARTY_PATH") . "configs/";
$smarty->cache_dir = constant("SMARTY_PATH") . "cache/";

$page = new Page();
$page->pageIndexName = "page";
$page->firstText = "首页";
$page->prevText = "上一页";
$page->nextText = "下一页";
$page->lastText = "末页";

header("Content-Type:text/html; charset=" . constant("WEB_CHARSET"));

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
