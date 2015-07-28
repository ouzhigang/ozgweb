<?php
require('init.php');
require_once('../comm_bll/share.php');

$act = isset($_REQUEST["act"]) ?  $_REQUEST["act"] : "list";

if($act == "list") {
	
	$smarty->display('admin/admin_data_list.html');
}
elseif($act == "getlist") {	
	
	$page = isset($_REQUEST["page"]) ? intval($_REQUEST["page"]) : 1;
	$page_size = isset($_REQUEST["page_size"]) ? intval($_REQUEST["page_size"]) : 25;
	
	$type = isset($_REQUEST["type"]) ? intval($_REQUEST["type"]) : 0;
	$dataclass_id = isset($_REQUEST["dataclass_id"]) ? intval($_REQUEST["dataclass_id"]) : 0;
	
	$wq = "type = " . $type;
	$wq_list = "d.type = " . $type;
	if($dataclass_id) {		
		get_children_id($dataclass_id);
		$children_id = implode(",", $children_id);
		$wq .= " and dataclass_id in(" . $children_id . ")";
		$wq_list .= " and d.dataclass_id in(" . $children_id . ")";
	}
	
	$sql = SqlText::func("count", "id", "data", $wq);	
	$total = $db->get_var($sql);
	
	$page_count = page_count($total, $page_size);
	
	$sql = "select d.* , dc.id as dc_id , dc.name as dc_name from data as d inner join dataclass as dc on d.dataclass_id = dc.id where " . $wq_list . " order by d.sort desc , d.id desc limit " . (($page - 1) * $page_size) . " , " . $page_size;
	$list = $db->get_results($sql, ARRAY_A);
	
	foreach($list as &$v) {
		$v["add_time"] = date("Y-m-d H:i:s", $v["add_time"]);
	}
	
	output_json(
		0, 
		"请求成功", 
		array(
			"total" => $total,
			"page" => $page,
			"page_count" => $page_count,
			"list" => $list			
		)
	);
	
}
elseif($act == "add") {	
		
	$id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : 0;
	if($id) {
		$row = $db->get_row("select * from data where id = " . $id, ARRAY_A);	
		$row["content"] = html_entity_decode($row["content"]);
	}
	else {
		$row = array(
			"id" => 0,
			"name" => "",
			"sort" => 0,
			"dataclass_id" => 0,
			"content" => "",
			"type" => intval($_REQUEST['type'])
		);	
	}
	$smarty->assign('row', $row);
		
	$smarty->display('admin/admin_data_add.html');
}
elseif($act == "addsubmit") {
	
	$list = array(
		"name" => str_filter($_REQUEST["name"]),
		"content" => str_filter($_REQUEST["content"]),
		"sort" => intval($_REQUEST["sort"]),
		"dataclass_id" => intval($_REQUEST["dataclass_id"]),
		"type" => intval($_REQUEST["type"])
	);
	
	$id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : 0;

	if($id) {
		$sql = SqlText::update("data", $list, "id=" . $id);
		$db->query($sql);
		output_json(0, "更新成功");
	}
	else {		
		$list["add_time"] = time();
		$list["hits"] = 0;
		$sql = SqlText::insert("data", $list);
		$db->query($sql);
		output_json(0, "添加成功");
	}
}
elseif($act == "del") {
	$sql = "delete from data where id = " . intval($_REQUEST["id"]);
	$db->query($sql);
	output_json(0, "删除成功");
}
else
	exit("错误请求");	
