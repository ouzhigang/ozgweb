<?php
require('init.php');

$runtime->start();
$smarty->assign('server_name', $_SERVER["SERVER_NAME"]);
$smarty->assign('get_ip', get_ip());
$smarty->assign('os', PHP_OS);
$smarty->assign('server_software', $_SERVER["SERVER_SOFTWARE"]);
$smarty->assign('php_version', PHP_VERSION);
$smarty->assign('upload_file_status', get_cfg_var("file_uploads") ? get_cfg_var("upload_max_filesize") : "<span class=\"f2\">不允许上传文件</span>");
$smarty->assign('max_execution_time', get_cfg_var("max_execution_time"));
$smarty->assign('document_root', $_SERVER["DOCUMENT_ROOT"]);
$smarty->assign('now', now());

$runtime->stop();
$smarty->assign('spent', "页面执行时间: " . $runtime->spent() . " 毫秒");

$smarty->display('admin/admin_main.html');
