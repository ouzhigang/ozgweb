<?php
require("init.php");

$smarty->assign('web_name', constant("WEB_NAME"));
$smarty->display('admin/admin_index.html');
