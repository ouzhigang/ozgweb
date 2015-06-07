<?php
require("init.php");

$act = isset($_REQUEST["act"]) ?  $_REQUEST["act"] : "default";

if($act == "default") {
	$smarty->assign('web_name', constant("WEB_NAME"));
	
	if(isset($_COOKIE["curr_user_name"])) {
		//一周内自动登录
		
		$name = str_filter(urldecode($_COOKIE["curr_user_name"]));
		$name = Encrypt::decode($name);
		$sql = "select * from user where name = '" . $name . "'";
		$user = $db->get_row($sql, ARRAY_A);
		
		unset($user["pwd"]);
		$_SESSION["curr_user"] = $user;
		$user["err_login"] = 0;
		
		$id = $user["id"];
		unset($user["id"]);
		$db->query(SqlText::update("user", $user, "id = " . $id));
		
		header("location:admin_index.php");
		exit();
	}
	elseif(isset($_SESSION["curr_user"])) {
		header("location:admin_index.php");
		exit();
	}
	
	$smarty->display(WEBPATH_ADMIN . '/index.html');
}
elseif($act == "login") {
	$name = str_filter($_REQUEST["name"]);
	$pwd = str_filter($_REQUEST["pwd"]);
	
	$sql = "select * from user where name = '" . $name . "'";
	$user = $db->get_row($sql, ARRAY_A);
	if($user) {
				
		if($user["err_login"] >= 3) {
			if(isset($_REQUEST["vcode"]) && isset($_SESSION["admin_vcode"])) {
				if(strtolower($_REQUEST["vcode"]) != strtolower($_SESSION["admin_vcode"]))
					output_json(1, "验证码错误");
				
				unset($_SESSION["admin_vcode"]);
			}
			else
				output_json(2);
		}
		
		if($user["pwd"] == $pwd) {
			
			unset($user["pwd"]);
			$_SESSION["curr_user"] = $user;
			$user["err_login"] = 0;
			
			$id = $user["id"];
			unset($user["id"]);
			$db->query(SqlText::update("user", $user, "id = " . $id));
			
			if(isset($_REQUEST["remember"]) && $_REQUEST["remember"] == 1) {
				
				setcookie("curr_user_name", urlencode(Encrypt::encode($user["name"])), time() + (86400 * 7));
			}
			
			output_json(0, "登录成功");
		}
		else {
			$user["err_login"] += 1;
			
			$id = $user["id"];
			unset($user["id"]);
			unset($user["pwd"]);
			$db->query(SqlText::update("user", $user, "id = " . $id));
			
			output_json(1, "密码错误");
		}
	}
	else
		output_json(1, "没有此用户");
}
else
	exit("错误请求");
