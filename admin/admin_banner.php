<?php
require('init.php');

$act = $_GET["act"] ?  $_GET["act"] : "show";

if($act == 'show') {
	$smarty->display('admin/admin_banner.html');
}
elseif($act == 'upload') {
	$hzs[] = ".jpg";
	if(upload($_FILES[$_GET['upload_name']], $hzs, constant('app_path') . 'images/' . $_GET['save_name'])) {
		msg_box('上传成功');
	}
	else {
		msg_box('上传失败');
	}
}
