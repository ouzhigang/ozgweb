<?php
require('init.php');
require_once('../comm_bll/share.php');

$act = isset($_REQUEST["act"]) ?  $_REQUEST["act"] : "list";

if($act == "list") {
	/*$runtime->start();
	$type = intval($_REQUEST["type"]);
	$dataclass_id = intval($_REQUEST["dataclass_id"]);
	$keywords = str_filter($_REQUEST["keywords"]);
	
	$wq = "type = " . $type;
	$wq_list = "d.type = " . $type;
	$page->query = "type=" . $type;
	if($dataclass_id) {
		$page->query .= "&dataclass_id=" . $dataclass_id;		
		
		get_children_id($dataclass_id);
		$children_id = implode(",", $children_id);
		$wq .= " and dataclass_id in(" . $children_id . ")";
		$wq_list .= " and d.dataclass_id in(" . $children_id . ")";
	}	
	if($keywords) {
		$page->query .= "&keywords=" . urlencode($keywords);
		$wq .= " and name like '%" . $keywords . "%'";
		$wq_list .= " and d.name like '%" . $keywords . "%'";
	}
	
	$page->pageSize = 30;
	$sql = SqlText::func("count", "id", $table, $wq);	
	$recordCount = $db->get_var($sql);
	$page->recordCount = $recordCount;
	
	$sql = "select d.* , dc.id as dc_id , dc.name as dc_name from {$table} as d inner join {$table2} as dc on d.dataclass_id = dc.id where " . $wq_list . " order by d.sort desc , d.id desc limit " . SqlText::getStartIndex($page->pageIndex(), $page->pageSize) . " , " . $page->pageSize;
	$data = $db->get_results($sql, ARRAY_A);
	$page->paging();
	$page_str = "总数据:" . $page->recordCount() . " 每页显示:" . $page->pageSize() . " 页次:" . $page->pageIndex() . "/" . $page->pageCount() . "&nbsp;&nbsp;" . $page->first() . " " . $page->prev() . " " . $page->next() . " " . $page->last();
	$smarty->assign('data', $data);	
	$smarty->assign('page', $page_str);	
	
	$smarty->assign('table', $table);
	$smarty->assign('self', self());
	$smarty->assign('type', $type);
	
	$runtime->stop();
	$smarty->assign('spent', "页面执行时间: " . $runtime->spent() . " 毫秒");
	$smarty->assign('js_jquery', constant("JS_JQUERY"));*/
	$smarty->display('admin/admin_data_list.html');
}
elseif($act == "add") {	
	/*if($_REQUEST) {
		$list["name"] = str_filter($_REQUEST["name"]);
		$list["content"] = htmlspecialchars(str_filter($_REQUEST["content"]));
		$list["sort"] = intval($_REQUEST["sort"]);
		$list["dataclass_id"] = intval($_REQUEST["dataclass_id"]);
		$list["type"] = intval($_REQUEST["type"]);
		$id = intval($_REQUEST["id"]);

		if(!empty($_REQUEST["picture"])) {
			$list["picture"] = str_filter($_REQUEST["picture"]);
		}

		if($id) {
			$sql = SqlText::update($table, $list, "id=" . $id);
			$db->query($sql);
			msg_box('修改成功', 'admin_data.php?type=' . $list["type"]);
		}
		else {		
			$list["add_time"] = time();
			$list["del"] = 0;
			$list["hits"] = 0;
			$sql = SqlText::insert($table, $list);
			$db->query($sql);
			msg_box('添加成功', 'admin_data.php?type=' . $list["type"]);
		}	
	}
	
	$runtime->start();
	
	$id = intval($_REQUEST["id"]);
	if($id) {
		$row = $db->get_row(SqlText::select("*", $table, "id=" . $id, null, null, null, null), ARRAY_A);	
		$row["content"] = html_entity_decode($row["content"]);
	}
	else {
		$row = array(
			"sort" => "0"
		);	
	}
	$smarty->assign('row', $row);
	$smarty->assign('id', $id);
	$smarty->assign('type', $_REQUEST["type"]);
	
	$smarty->assign("get_tree_selector", get_tree_selector(intval($_REQUEST["type"])));
	
	$runtime->stop();
	$smarty->assign('spent', "页面执行时间: " . $runtime->spent() . " 毫秒");
	$smarty->assign('js_jquery', constant("JS_JQUERY"));*/
	$smarty->display('admin/admin_data_add.html');
}
elseif($act == "del") {
	/*$sql = SqlText::delete($table, "id=" . intval($_REQUEST["id"]));
	$db->query($sql);
	msg_box("删除成功", "admin_data.php?type=" . $_REQUEST["type"]);*/
}
else
	exit("错误请求");	
