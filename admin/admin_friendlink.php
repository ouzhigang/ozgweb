<?php
require('init.php');

$table = constant('DB_PREFIX') . "friendlink";
$id = intval($_GET["id"]);

$act = $_GET["act"] ?  $_GET["act"] : "show";

if($act == "show") {
	$runtime->start();
	
	$order = "sort desc , id desc";
	$sql = "select * from " . $table . " order by " . $order;
	$data = $db->get_results($sql, ARRAY_A);
	$smarty->assign('data', $data);
	
	$smarty->assign('table', $table);
	$smarty->assign('self', self());
	
	$runtime->stop();
	$smarty->assign('spent', "页面执行时间: " . $runtime->spent() . " 毫秒");
	$smarty->display('admin/admin_friendlink_list.html');
}
elseif($act == "add") {	
	if($_POST) {
		$list["name"] = str_filter($_POST["name"]);
		$list["url"] = str_filter($_POST["url"]);		
		$list["sort"] = intval($_POST["sort"]);		
		$list["is_picture"] = intval($_POST['is_picture']);
		if($_POST['is_picture']) {
			$list["picture"] = str_filter($_POST['picture']);		
		}
		$id = intval($_POST["id"]);
		
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
	
	$id = intval($_GET["id"]);
	if($id) {
		$row = $db->get_row(SqlText::select("*", $table, "id=" . $id, null, null, null, null), ARRAY_A);	
	}
	else {
		$row = array(
			"sort" => "0"
		);	
	}
	$smarty->assign('row', $row);
	
	$smarty->display('admin/admin_friendlink_add.html');
}
elseif($act == "del") {
	$where = "id=" . intval($_GET["id"]);
	$sql = SqlText::delete($table, $where);
	$db->query($sql);
	msg_box('删除成功', self());
}
else
	exit("错误请求");	
