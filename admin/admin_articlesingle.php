<?php
require('init.php');

$act = isset($_REQUEST["act"]) ?  $_REQUEST["act"] : "show";

if($act == "show") {
	$runtime->start();
	
	/*$id = intval($_REQUEST["id"]);
	$sql = SqlText::select("*", $table, "id=" . $id, null, null, null, null);	
	$row = $db->get_row($sql, ARRAY_A);	
	$row["content"] = html_entity_decode($row["content"]);
	$smarty->assign('row', $row);
	
	$runtime->stop();
	$smarty->assign('js_jquery', constant("JS_JQUERY"));
	$smarty->assign('spent', "页面执行时间: " . $runtime->spent() . " 毫秒");*/
	$smarty->display('admin/admin_articlesingle.html');
}
elseif($act == "update") {
	/*$id = intval($_REQUEST["id"]);
	$content = htmlspecialchars(str_filter($_REQUEST["content"]));
	$sql = "update " . $table . " set content = '" . $content . "' where id = " . $id;
	$db->query($sql);
	msg_box("更新成功");	*/
}
