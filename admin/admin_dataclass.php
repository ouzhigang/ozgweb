<?php
require('init.php');
require_once('../comm_bll/share.php');

$act = isset($_REQUEST["act"]) ?  $_REQUEST["act"] : "list";

if($act == "list") {
	/*$runtime->start();
	
	$smarty->assign("jquery_tree_table", get_jquery_tree_table(intval($_REQUEST["type"])));
	
	$runtime->stop();
	$smarty->assign('spent', "页面执行时间: " . $runtime->spent() . " 毫秒");*/
	$smarty->display('admin/admin_dataclass_list.html');
}
elseif($act == "add") {
	/*if($_REQUEST) {
		$list["name"] = str_filter($_REQUEST["name"]);
		$list["sort"] = intval($_REQUEST["sort"]);	
		$list["parent_id"] = intval($_REQUEST["parent_id"]);	
		$list["depth"] = 0;	
		$list["root_id"] = 0;
		$list["type"] = intval($_REQUEST['type']);	
		$id = intval($_REQUEST["id"]);
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
	
	$id = intval($_REQUEST["id"]);
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
	
	$smarty->assign("type", $_REQUEST["type"]);
	$smarty->assign("row", $row);
	$smarty->assign("get_tree_selector", get_tree_selector(intval($_REQUEST["type"])));
	
	$runtime->stop();
	$smarty->assign('spent', "页面执行时间: " . $runtime->spent() . " 毫秒");
	$smarty->assign('js_jquery', constant("JS_JQUERY"));*/
	$smarty->display('admin/admin_dataclass_add.html');	
}
elseif($act == "del") {
	//do_del(intval($_REQUEST['id']));
	//msg_box("删除成功", "admin_dataclass.php?type=" . $_REQUEST['type']);		
}
else
	exit("错误请求");	
