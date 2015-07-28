<?php
require('init.php');

$act = $_GET["act"] ?  $_GET["act"] : "show";

if($act == "show") {
	
	$smarty->display('admin/upload.html');
}
elseif($act == "upload") {
	$id = $_GET["id"];
	$name = $_GET["name"];

	//设置文件后缀名
	$hzs = array();
	$hzs[] = ".gif";
	$hzs[] = ".jpg";
	$hzs[] = ".jpeg";
	$hzs[] = ".bmp";
	$hzs[] = ".png";
	
	//上传目录 (如果是上级的upload,要改成../upload/)
	$dir = constant("UPLOAD_PATH");
	$dir = $_SERVER["DOCUMENT_ROOT"] . $dir;
	
	//上传文件大小(10M)
	$max = 10 * 1000 * 1000 * 1000;
	
	//开始执行	
	if(!is_writable($dir)) {
		$content = "<script>";
		$content .= "alert('上传目录没有写入权限');";
		$content .= "close();";
		$content .= "</script>";
		echo $content;
		exit();
	}
	
	$is_ok = false;	
	if($_FILES["upload"]["size"] <= $max) {
		$is_ok = true;
	}
	
	$hz = strtolower(strrchr($_FILES["upload"]["name"],"."));	
	if($is_ok) {
		for($i = 0; $i < count($hzs); $i++) {
			if($hzs[$i] == $hz) {
				$is_ok = true;
				break;
			}
			else {
				$is_ok = false;
			}
		}
	}
	
	$smarty->assign('is_ok', $is_ok);
	
	if($is_ok) {
		$file_name = date("YmdHis") . $hz;
		$path = $dir . $file_name;
		
		//这里是目标路径 ../或空值
		move_uploaded_file($_FILES["upload"]["tmp_name"], "" . $path);
		$content = "<script>";
		if(empty($name)) {
			$content .= "opener.parent.document.getElementById('" . $id . "').value='" . constant("UPLOAD_PATH") . $file_name . "';";
		}
		else {
			$content .= "opener.parent." . $name . ".document.getElementById('" . $id . "').value='" . constant("UPLOAD_PATH") . $file_name . "';";
		}
		$content .= "close();";
		$content .= "</script>";

		header("Content-type:text/html;charset=utf-8");
		echo $content;
		exit();
	}
	
	$smarty->display('admin/upload.html');
}
elseif($act == "ckupload") {

	$callback = $_REQUEST["CKEditorFuncNum"];

	//设置文件后缀名
	$hzs = array();
	$hzs[] = ".gif";
	$hzs[] = ".jpg";
	$hzs[] = ".jpeg";
	$hzs[] = ".bmp";
	$hzs[] = ".png";
	
	$dir = constant("UPLOAD_PATH");
	$dir = $_SERVER["DOCUMENT_ROOT"] . $dir;

	//上传文件大小(10M)
	$max = 10 * 1000 * 1000 * 1000;
	
	//开始执行	
	if(!is_writable($dir)) {
	
		$content = "<script type=\"text/javascript\">";
		$content .= "window.parent.CKEDITOR.tools.callFunction(" . $callback . ", '', '上传目录没有写入权限');";
		$content .= "</script>"; 
		header("Content-type:text/html;charset=utf-8");
		echo $content;
		exit();
	}

	$is_ok = false;	
	if($_FILES["upload"]["size"] <= $max) {
		$is_ok = true;
	}
	
	$hz = strtolower(strrchr($_FILES["upload"]["name"],"."));	
	if($is_ok) {
		for($i = 0; $i < count($hzs); $i++) {
			if($hzs[$i] == $hz) {
				$is_ok = true;
				break;
			}
			else {
				$is_ok = false;
			}
		}
	}
	
	if($is_ok) {
			
		$file_name = date("YmdHis") . $hz;
		$path = $dir . $file_name;

		//这里是目标路径 ../或空值
		move_uploaded_file($_FILES["upload"]["tmp_name"], "" . $path);
		
		$content = "<script type=\"text/javascript\">";
		$content .= "window.parent.CKEDITOR.tools.callFunction(" . $callback . ",'" . constant("UPLOAD_PATH") . $file_name . "','')";
		$content .= "</script>";
		header("Content-type:text/html;charset=utf-8");
		echo $content;		
	}
	else {
		$content = "<script type=\"text/javascript\">";
		$content .= "window.parent.CKEDITOR.tools.callFunction(" . $callback . ", '', '上传失败！');";
		$content .= "</script>"; 
		header("Content-type:text/html;charset=utf-8");
		echo $content;
		exit();
	}
		
}
