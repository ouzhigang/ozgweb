<?php
require('init.php');
require_once('../comm_bll/share.php');

$act = isset($_REQUEST["act"]) ?  $_REQUEST["act"] : "list";

$depth = NULL;
function get_data($parent_id) {
	global $db, $depth;
	
	$sql = "select * from dataclass where parent_id = " . $parent_id . " and type = " . intval($_REQUEST["type"]) . " order by sort desc, id desc";
	$data2 = $db->get_results($sql, ARRAY_A);
	foreach($data2 as &$v) {
		
		$depth++;
		$v["depth"] = $depth;
		$v["child_list"] = get_data($v["id"]);
		$depth--;
	}
	return $data2;
}

if($act == "list") {
	
	$smarty->display('admin/admin_dataclass_list.html');
}
elseif($act == "getlist") {
	$sql = "select * from dataclass where parent_id = 0 and type = " . intval($_REQUEST["type"]) . " order by sort desc, id desc";
	$data = $db->get_results($sql, ARRAY_A);
	foreach($data as &$v) {
		$depth = 0;
		$v["depth"] = $depth;
		$v["child_list"] = get_data($v["id"]);		
	}
	output_json(0, "请求成功", $data);
}
elseif($act == "add") {	
	$id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : 0;
	$type = isset($_REQUEST["type"]) ? intval($_REQUEST["type"]) : 0;
	
	$row = NULL;
	if($id) {
		$sql = "select * from dataclass where id = " . $id;
		$row = $db->get_row($sql, ARRAY_A);
	}
	else{
		$row = array(
			"id" => 0,
			"name" => "",
			"type" => $type,
			"parent_id" => 0,
			"sort" => 0
		);	
	}
	
	$smarty->assign("row", $row);
	$smarty->display('admin/admin_dataclass_add.html');	
}
elseif($act == "addsubmit") {
	$list = array(
		"name" => str_filter($_REQUEST["name"]),
		"sort" => intval($_REQUEST["sort"]),
		"parent_id" => intval($_REQUEST["parent_id"]),
		"type" => intval($_REQUEST['type'])
	);
	
	$id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : 0;
	if($id) {			
		$sql = SqlText::update("dataclass", $list, "id = " . $id);
		$db->query($sql);
		output_json(0, "更新成功");
	}
	else {
		$sql = SqlText::insert("dataclass", $list);
		$db->query($sql);
		output_json(0, "添加成功");
	}
}
elseif($act == "get_tree_selector") {
	//获取
	
	$type = isset($_REQUEST["type"]) ? intval($_REQUEST["type"]) : 0;
	
	$data = get_tree_selector($type);
	output_json(0, "请求成功", $data);
}
elseif($act == "del") {
	do_del(intval($_REQUEST['id']));
	output_json(0, "删除成功");
}
else
	exit("错误请求");	
