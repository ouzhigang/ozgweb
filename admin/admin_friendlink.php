<?php
require('init.php');

$act = isset($_REQUEST["act"]) ?  $_REQUEST["act"] : "list";

if($act == "list") {
	
	$sql = "select * from friendlink order by sort desc, id desc";
	$data = $db->get_results($sql, ARRAY_A);
	$smarty->assign('data', $data);
		
	$smarty->display('admin/admin_friendlink_list.html');
}
elseif($act == "add") {	
	
	$id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : 0;
	$row = null;
	if($id != 0) {
		$row = $db->get_row("select * from friendlink where id = " . $id, ARRAY_A);	
	}
	else {
		$row = array(
			"id" => 0,
			"name" => "",
			"url" => "",
			"is_picture" => 0,
			"picture" => "",
			"sort" => "0"
		);	
	}
	$smarty->assign('row', $row);
	$smarty->display('admin/admin_friendlink_add.html');
}
elseif($act == "addsubmit") {
	$list = array(
		"name" => str_filter($_REQUEST["name"]),
		"url" => str_filter($_REQUEST["url"]),
		"sort" => intval($_REQUEST["sort"]),
		"is_picture" => isset($_REQUEST['is_picture']) ? intval($_REQUEST['is_picture']) : 0,
	);
	if($list["is_picture"])
		$list["picture"] = str_filter($_REQUEST['picture']);
	else
		$list["picture"] = "";
	
	$id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : 0;
	
	if($id) {
		$sql = SqlText::update("friendlink", $list, "id=" . $id);
		$db->query($sql);
		output_json(0, "修改成功");
	}
	else {
		$sql = SqlText::insert("friendlink", $list);	
		$db->query($sql);
		output_json(0, "添加成功");
	}
}
elseif($act == "del") {
	$where = "id=" . intval($_REQUEST["id"]);
	$sql = SqlText::delete("friendlink", $where);
	$db->query($sql);
	output_json(0, "删除成功");
}
else
	exit("错误请求");	
