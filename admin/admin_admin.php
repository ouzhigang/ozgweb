<?php
require('init.php');

$act = $_GET["act"] ?  $_GET["act"] : "show";

if($act == "show") {
	$runtime->start();
	$table = constant('DB_PREFIX') . "admin";
	$order = "id asc";
	$sql = "select * from " . $table . " order by " . $order;
	$data = $db->get_results($sql, ARRAY_A);
	$smarty->assign('data', $data);
	$runtime->stop();
	$smarty->assign('spent', "页面执行时间: " . $runtime->spent() . " 毫秒");
	$smarty->display('admin/admin_admin_list.html');
}
elseif($act == "add") {
	if($_POST) {
		$name = str_filter($_POST["name"]);
		$pwd = str_filter($_POST["pwd"]);
		$pwd2 = str_filter($_POST["pwd2"]);
		if($pwd == $pwd2) {
			$table = constant('DB_PREFIX') . "admin";
			$result = $db->get_var("select count(id) from " . $table . " where name='" . $name . "'");
			if($result) {
				msg_box("此用户已存在");
			}
			
			$list["name"] = $name;
			$list["pwd"] = md5($pwd);
			$list["add_time"] = time();
			$sql = SqlText::insert($table, $list);	
			$db->query($sql);
			msg_box("添加成功！", "admin_admin.php");
		}
		else {
			msg_box("第二次输入密码不正确");
		}
	}
	
	$smarty->display('admin/admin_admin_add.html');
}
elseif($act == "del") {
	$id = intval($_GET["id"]);
	if($id == $_SESSION["admin_id"]) {
		msg_box("不能删除自己");
	}
	else {
		$table = constant('DB_PREFIX') . "admin";
		$where = "id=" . $_GET["id"];
		$sql = SqlText::delete($table, $where);
		$db->query($sql);
		msg_box("删除成功", "admin_admin.php");	
	}
}
elseif($act == "pwd") {
	if($_POST) {
		$old = str_filter($_POST["old"]);
		$pwd = str_filter($_POST["pwd"]);
		$pwd2 = str_filter($_POST["pwd2"]);		
			
		if($pwd == $pwd2) {		
			$table = constant('DB_PREFIX') . "admin";
			$sql = SqlText::func("count", "id", $table, "name='" . $_SESSION["admin"]["name"] . "' and pwd='" . md5($old) . "'");
			$result = $db->get_var($sql);
			if($result) {
				$list["pwd"] = md5($pwd);
				$_SESSION["admin"]["pwd"] = $list["pwd"];
				$db->query(SqlText::update($table, $list, "name='" . $_SESSION["admin"]["name"] . "'"));
				msg_box("修改成功", 'admin_admin.php?act=pwd');
			}
			else {
				msg_box("旧密码错误");
			}
		}
		else {
			msg_box("第二次输入密码不正确");
		}	
	}
	
	$smarty->display('admin/admin_admin_pwd.html');
}
else
	exit("错误请求");	
