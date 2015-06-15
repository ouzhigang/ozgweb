<?php
require('init.php');

$act = isset($_REQUEST["act"]) ?  $_REQUEST["act"] : "list";

if($act == "list") {
	
	$smarty->display('admin/admin_feedback_list.html');
}
elseif($act == "getlist") {
	
	$page = isset($_REQUEST["page"]) ? intval($_REQUEST["page"]) : 1;
	$page_size = isset($_REQUEST["page_size"]) ? intval($_REQUEST["page_size"]) : 25;
	
	$sql = "select count(id) from feedback";
	$total = $db->get_var($sql);
	
	$page_count = page_count($total, $page_size);
	
	$sql = "select * from feedback order by id desc limit " . (($page - 1) * $page_size) . ", " . $page_size;
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
elseif($act == "del") {
	$where = "id=" . intval($_REQUEST["id"]);
	$sql = SqlText::delete("feedback", $where);
	$db->query($sql);
	output_json(0, "删除成功");
}
else
	exit("错误请求");	
