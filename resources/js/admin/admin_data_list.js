
require(
	[ "config" ], 
	function () {
		require([ "admin.data_list" ]);
	}), 
	define("admin.data_list", [ "jquery", "jquery_ui", "bootstrap", "metisMenu", "sb_admin_2", "md5", "common" ], function ($) {
		page_init();
		
		$('#dataTables-example').DataTable({
			"responsive": true,
			"language": {
				"info": "页次 _PAGE_ / _PAGES_",
				"infoEmpty": "没有数据",
				"loadingRecords": "数据读取中...",
				"lengthMenu": "显示 _MENU_ 条记录",
				"paginate": {
					"first": "首页",
					"previous": "上一页",
					"next": "下一页",
					"last": "末页"
				}
			},
			"pageLength": 25,
			"searching": false,
			"processing": true,
			/*"ajax": {
				"url": "data.json",
				"dataSrc": function(json) {
					for(var i = 0; i < json.length; i++) {
						json[i][0] = "<a href=\"message\">View message</a>";
					}
					return json;
				}
			}*/
			
        });
		
	}
);
