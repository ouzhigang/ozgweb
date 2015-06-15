<?php
require('init.php');

$act = isset($_REQUEST["act"]) ?  $_REQUEST["act"] : "list";

if($act == "list") {
	$sql = "select * from user order by id asc";
	$data = $db->get_results($sql, ARRAY_A);
	
	foreach($data as &$v) {
		$v["add_time"] = date("Y-m-d H:i:s", $v["add_time"]);
	}
	
	$smarty->assign('data', $data);
	$smarty->display('admin/admin_admin_list.html');
}
elseif($act == "add") {
		
	$smarty->display('admin/admin_admin_add.html');
}
elseif($act == "addsubmit") {
	$name = str_filter($_REQUEST["name"]);
	$pwd = str_filter($_REQUEST["pwd"]);
	$pwd2 = str_filter($_REQUEST["pwd2"]);
	if($pwd == $pwd2) {
		$result = $db->get_var("select count(id) from user where name='" . $name . "'");
		if($result) {
			output_json(1, "此用户已存在");
		}
		
		$list = array(
			"name" => $name,
			"pwd" => $pwd,
			"add_time" => time()
		);
		$sql = SqlText::insert("user", $list);
		$db->query($sql);
		
		output_json(0, "添加成功！");
	}
	else {
		output_json(1, "第二次输入密码不正确");
	}
}
elseif($act == "del") {
	$id = intval($_REQUEST["id"]);
	if($id == $_SESSION["curr_user"]["id"]) {
		output_json(1, "不能删除自己");
	}
	else {
		$where = "id=" . $_REQUEST["id"];
		$sql = SqlText::delete("user", $where);
		$db->query($sql);
		output_json(0, "删除成功");
	}
}
elseif($act == "pwd") {
		
	$smarty->display('admin/admin_admin_pwd.html');
}
elseif($act == "pwdsubmit") {
	$old_pwd = str_filter($_REQUEST["old_pwd"]);
	$pwd = str_filter($_REQUEST["pwd"]);
	$pwd2 = str_filter($_REQUEST["pwd2"]);		
		
	if($pwd == $pwd2) {
		$sql = SqlText::func("count", "id", "user", "name='" . $_SESSION["curr_user"]["name"] . "' and pwd='" . $old_pwd . "'");
		$result = $db->get_var($sql);
		if($result) {
			$list = array(
				"pwd" => $pwd
			);
			$db->query(SqlText::update("user", $list, "name='" . $_SESSION["curr_user"]["name"] . "'"));
			output_json(0, "修改成功");
		}
		else {
			output_json(1, "旧密码错误");
		}
	}
	else {
		output_json(1, "第二次输入密码不正确");
	}
}
else
	exit("错误请求");	
