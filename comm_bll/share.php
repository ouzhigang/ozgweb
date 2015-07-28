<?php
require_once("../comm/functions.php");

//这里的引用来自php.ini的公用include
require_once("ez_sql/ez_sql_core.php");
require_once("ez_sql/ez_sql_pdo.php");

function get_tree_selector($type) {
	global $db;
	$data = array();
	$list = $db->get_results('select * from dataclass where parent_id = 0 and type = ' . $type . ' order by sort desc, id desc' , ARRAY_A);
	foreach($list as $item) {
		$data[] = array(
			"id" => $item["id"],
			"parent_id" => 0,
			"name" => $item["name"]
		);
		$results = $db->get_row('select count(id) from dataclass where parent_id = ' . $item["id"]);
		if($results) {
			tree_selector($data, $item["id"]);
		}
	}
	return $data;
}

function tree_selector(&$data, $parent_id) {
	global $db;
	$list = $db->get_results('select * from dataclass where parent_id = ' . $parent_id . ' order by sort desc, id desc' , ARRAY_A);
	foreach($list as $item) {
		$data[] = array(
			"id" => $item["id"],
			"parent_id" => $item["parent_id"],
			"name" => $item["name"]
		);
		tree_selector($data, $item["id"]);
	}
}

function do_del($id) {
	global $db;
	$db->query('delete from dataclass where id = ' . $id);
	$db->query('delete from data where dataclass_id = ' . $id);
	$list = $db->get_results('select * from dataclass where parent_id = ' . $id . ' order by sort desc, id desc' , ARRAY_A);
	foreach($list as $item) {			
		do_del($item["id"]);
	}
}

function get_children_id($id) {
	global $db, $children_id;
	$table_name = "dataclass";
	$field_id = "id";
	$field_parent_id = "parent_id";
	if(!$children_id) {
		$children_id = array();
		//添加当前分类的ID
		$children_id[] = $id;
	}
	$sql = "select " . $field_id . " from " . $table_name . " where " . $field_parent_id . " = " . $id;
	$children_data = $db->get_results($sql, ARRAY_A);
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
