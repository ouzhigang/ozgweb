<?php
require('init.php');

$act = isset($_REQUEST["act"]) ?  $_REQUEST["act"] : "list";

if($act == "list") {
	/*$runtime->start();
	
	$sql = "select * from friendlink order by sort desc , id desc";
	$data = $db->get_results($sql, ARRAY_A);
	$smarty->assign('data', $data);
	
	$smarty->assign('self', self());
	
	$runtime->stop();
	$smarty->assign('spent', "页面执行时间: " . $runtime->spent() . " 毫秒");*/
	$smarty->display('admin/admin_feedback_list.html');
}
elseif($act == "add") {	
	/*if($_REQUEST) {
		$list["name"] = str_filter($_REQUEST["name"]);
		$list["url"] = str_filter($_REQUEST["url"]);		
		$list["sort"] = intval($_REQUEST["sort"]);		
		$list["is_picture"] = intval($_REQUEST['is_picture']);
		if($_REQUEST['is_picture']) {
			$list["picture"] = str_filter($_REQUEST['picture']);		
		}
		$id = intval($_REQUEST["id"]);
		
		if($id) {
			$sql = SqlText::update($table, $list, "id=" . $id);
			$db->query($sql);
			msg_box('修改成功', 'admin_friendlink.php');
		}
		else {
			$sql = SqlText::insert($table, $list);	
			$db->query($sql);
			msg_box('添加成功', 'admin_friendlink.php');		
		}
	}
	
	$id = intval($_REQUEST["id"]);
	if($id) {
		$row = $db->get_row(SqlText::select("*", $table, "id=" . $id, null, null, null, null), ARRAY_A);	
	}
	else {
		$row = array(
			"sort" => "0"
		);	
	}
	$smarty->assign('row', $row);*/
	
	$smarty->display('admin/admin_friendlink_add.html');
}
elseif($act == "del") {
	/*$where = "id=" . intval($_REQUEST["id"]);
	$sql = SqlText::delete($table, $where);
	$db->query($sql);
	msg_box('删除成功', self());*/
}
else
	exit("错误请求");	
