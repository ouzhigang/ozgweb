<?php
require('init.php');

$act = isset($_REQUEST["act"]) ?  $_REQUEST["act"] : "default";

if($act == "default") {
	$id = intval($_REQUEST["id"]);
	$sql = "select * from articlesingle where id = " . $id;	
	$row = $db->get_row($sql, ARRAY_A);	
	$row["content"] = html_entity_decode($row["content"]);
	$smarty->assign('row', $row);
	
	$smarty->display('admin/admin_articlesingle.html');
}
elseif($act == "update") {
	$id = intval($_REQUEST["id"]);
	$content = str_filter($_REQUEST["content"]);
	$sql = "update articlesingle set content = '" . $content . "' where id = " . $id;
	$db->query($sql);
	output_json(0, "更新成功");
}
