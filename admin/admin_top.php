<?php
require('init.php');

$act = $_GET["act"] ?  $_GET["act"] : "show";
if($act == "show") {
	$smarty->assign('admin_name', $_SESSION["admin"]["name"]);
	$smarty->display('admin/admin_top.html');
}
elseif($act == "loginout") {
	$_SESSION["admin_id"] = NULL;
	$_SESSION["admin"] = NULL;
	msg_box("退出登录", "login.php", "parent");
}
else
	exit("错误请求");	
