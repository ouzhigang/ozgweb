<?php
require_once("../comm/functions.php");

//这里的引用来自php.ini的公用include
require_once("ez_sql/ez_sql_core.php");
require_once("ez_sql/ez_sql_pdo.php");

function get_tree_selector($type) {
	global $db;
	$content = '';
	$content .= "var data = new Array();\r\n";
	$list = $db->get_results('select * from dataclass where parent_id=0 and Type=' . $type . ' order by sort desc,id desc' , ARRAY_A);
	foreach($list as $item) {
		$content .= "data.push({id:'" . $item["id"] . "',pid:'0',text:'" . $item["name"] . "'});\r\n";
		$results = $db->get_row('select count(id) from dataclass where parent_id=' . $item["id"]);
		if($results) {
			$content .= tree_selector($item["id"]);
		}
	}
	return $content;
}

function tree_selector($parent_id) {
	global $db;
	$content = '';
	$list = $db->get_results('select * from dataclass where parent_id=' . $parent_id . ' order by sort desc,id desc' , ARRAY_A);
	foreach($list as $item) {
		$content .= "data.push({id:'" . $item["id"] . "',pid:'" . $item["parent_id"] . "',text:'" . $item["name"] . "'});\r\n";
		$content .= tree_selector($item["id"]);
	}
	return $content;
}

function get_jquery_tree_table($type) {
	global $db;
	$content = '';
	$list = $db->get_results('select * from dataclass where parent_id=0 and Type=' . $type . ' order by sort desc,id desc' , ARRAY_A);
	foreach($list as $item) {
		$content .= "<tr id='" . $item["id"] . "'>\r\n";
		$content .= "\t<td><a href='admin_data.php?type=" . $item["type"] . "&dataclass_id=" . $item["id"] . "'>" . $item["name"] . "</a></td>\r\n";
		$content .= "\t<td><a href='admin_dataclass.php?act=add&type=" . $item["type"] . "&id=" . $item["id"] . "'>编辑</a> | <a onclick='return confirm(\"确认删除吗？\")' href='" . self() . "?act=del&type=" . $item["type"] . "&id=" . $item["id"] . "'>删除</a></td>\r\n";
		$content .= "</tr>\r\n";
		$content .= jquery_tree_table($item["id"]);
	}
	return $content;
}

function jquery_tree_table($parent_id) {
	global $db;
	$content = '';
	$list = $db->get_results('select * from dataclass where parent_id=' . $parent_id . ' order by sort desc,id desc' , ARRAY_A);
	foreach($list as $item) {
		$content .= "<tr id='" . $item["id"] . "' class='child-of-" . $item["parent_id"] . "'>\r\n";
		$content .= "\t<td><a href='admin_data.php?type=" . $item["type"] . "&dataclass_id=" . $item["id"] . "'>" . $item["name"] . "</a></td>\r\n";
		$content .= "\t<td><a href='admin_dataclass.php?act=add&type=" . $item["type"] . "&id=" . $item["id"] . "&parent_id=" . $item["parent_id"] . "'>编辑</a> | <a onclick='return confirm(\"确认删除吗？\")' href='" . self() . "?act=del&type=" . $item["type"] . "&id=" . $item["id"] . "'>删除</a></td>\r\n";
		$content .= "</tr>\r\n";
		$content .= jquery_tree_table($item["id"]);
	}
	return $content;
}

function do_del($id) {
	global $db;
	$db->query('delete from dataclass where id=' . $id);
	$db->query('delete from data where dataclass_id=' . $id);
	$list = $db->get_results('select * from dataclass where parent_id=' . $id . ' order by sort desc,id desc' , ARRAY_A);
	foreach($list as $item) {			
		do_del($item["id"]);
	}
}

function get_children_id($id) {
	global $db , $children_id;
	$table_name = "dataclass";
	$field_id = "id";
	$field_parent_id = "parent_id";
	if(!$children_id) {
		$children_id = array();
		//添加当前分类的ID
		$children_id[] = $id;
	}
	$sql = "select " . $field_id . " from " . $table_name . " where " . $field_parent_id . " = " . $id;
	$children_data = $db->get_results($sql , ARRAY_A);
	foreach($children_data as $v) {
		$children_id[] = intval($v[$field_id]);
		get_children_id($v[$field_id]);
	}
}

function output_json($code, $desc = null, $data = null) {
	
	$obj = array(
		"code" => $code
	);
	
	if($desc)
		$obj["desc"] = $desc;
	
	if($data)
		$obj["data"] = $data;
	
	header("Content-type:application/json; charset=utf-8");
	echo json_encode($obj);
	exit();
}
