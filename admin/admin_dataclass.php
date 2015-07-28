<?php
require('init.php');
require('../comm_bll/share.php');

$act = $_GET["act"] ?  $_GET["act"] : "show";

$table = constant('DB_PREFIX') . "dataclass";

if($act == "show") {
	$runtime->start();
	
	$smarty->assign("jquery_tree_table", get_jquery_tree_table(intval($_GET["type"])));
	
	$runtime->stop();
	$smarty->assign('spent', "页面执行时间: " . $runtime->spent() . " 毫秒");
	$smarty->assign('js_jquery', constant("JS_JQUERY"));
	$smarty->display('admin/admin_dataclass_list.html');
}
elseif($act == "add") {
	if($_POST) {
		$list["name"] = str_filter($_POST["name"]);
		$list["sort"] = intval($_POST["sort"]);	
		$list["parent_id"] = intval($_POST["parent_id"]);	
		$list["depth"] = 0;	
		$list["root_id"] = 0;
		$list["type"] = intval($_POST['type']);	
		$id = intval($_POST["id"]);
		if($id) {			
			$sql = SqlText::update($table, $list, "id = {$id}");	
			$db->query($sql);
			msg_box('修改成功', 'admin_dataclass.php?type=' . $list["type"]);
		}
		else {	
			$sql = SqlText::insert($table, $list);	
			$db->query($sql);
			msg_box('添加成功', 'admin_dataclass.php?type=' . $list["type"]);		
		}
	}
	
	$runtime->start();
	
	$id = intval($_GET["id"]);
	if($id) {
		$smarty->assign("id", $id);
		$sql = "select * from {$table} where id = {$id}";
		$row = $db->get_row($sql, ARRAY_A);
	}
	else{
		$row = array(
			"sort" =>  0
		);	
	}
	
	$smarty->assign("type", $_GET["type"]);
	$smarty->assign("row", $row);
	$smarty->assign("get_tree_selector", get_tree_selector(intval($_GET["type"])));
	
	$runtime->stop();
	$smarty->assign('spent', "页面执行时间: " . $runtime->spent() . " 毫秒");
	$smarty->assign('js_jquery', constant("JS_JQUERY"));
	$smarty->display('admin/admin_dataclass_add.html');	
}
elseif($act == "del") {
	do_del(intval($_GET['id']));
	msg_box("删除成功", "admin_dataclass.php?type=" . $_GET['type']);		
}
else
	exit("错误请求");	
