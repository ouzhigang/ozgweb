<?php
require("init.php");

$act = $_GET["act"] ?  $_GET["act"] : "show";

if($act == "show") {
	$smarty->assign('web_name', constant("WEB_NAME"));
	$smarty->assign('js_jquery', constant("JS_JQUERY"));
	$smarty->display('admin/login.html');
}
elseif($act == "login") {
	$name = str_filter($_POST["name"]);
	$pwd = str_filter($_POST["pwd"]);
	
	$sql = "select * from " . constant("DB_PREFIX") . "admin where name = '{$name}'";
	$row = $db->get_row($sql, ARRAY_A);
	if($row) {
		if($row["pwd"] == $pwd) {
			session_start();
			$_SESSION["admin_id"] = $row["id"];
			$_SESSION["admin"] = $row;
			header("location:admin_index.php");
		}
		else
			msg_box("密码错误");
		
	}
	else {
		//没有此用户
		msg_box("没有此用户");
	}
}
else
	exit("错误请求");	
