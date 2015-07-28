<?php
require('init.php');

/*
form1为表单
del为隐藏域
$_GET["t"]为目标表
<script>
function del()
{
	if(confirm('确认删除'))
	{
		var form1=document.getElementById("form1");
		var del=document.getElementById("del");
		var str="";
		for (var i=0;i<form1.elements.length;i++)
		{
			var e = form1.elements[i];
			if(e.type=="checkbox")
			{
				if(e.checked)
				{
					str+=e.value+",";
				}
			}
		}
		del.value=str.substring(0,str.length-1).replace("on,","");		
		
		form1.submit();
	}
}
</script>
*/


/*
$db->query('delete from '.constant('db_prefix').' where id in('.$_POST["del"].')');	


if(empty($_GET["url"]))
{
	Utility::msg("删除成功");
}
else
{
	Utility::msg("删除成功",$_GET["url"]);
}
*/

$t = str_filter($_GET['t']);
$del = str_filter($_POST["del"]);
$url = str_filter($_GET["url"]);
$type = str_filter($_GET["type"]);

if($del){
	if($t == constant('PDO_CONNECT') . "pictures") {
		//批量删除图片！
		$list = $db->get_results(SqlText::select("*", $t, "id in(" . $del . ")", "sort desc,id desc", null, null, null));		
		foreach($list as $item) {
			@unlink(get_lcation_path($item["picture"]));	
		}
	}

	$db->query('delete from ' . $t . ' where id in(' . $del . ')');	

	if(!$url) {
		msg_box("删除成功");
	}
	else {
		if($type) {
			msg_box("删除成功", $url . "?type=" . $type);
		}
		else {
			msg_box("删除成功", $url);
		}		
	}	
}
