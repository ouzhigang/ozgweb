
require.config({
    paths: {
        "jquery": "http://libs.useso.com/js/jquery/2.1.1/jquery.min",
		"jquery_ui": "http://libs.useso.com/js/jqueryui/1.10.4/jquery-ui.min",
		"bootstrap": "../../startbootstrap-sb-admin-2-1.0.7/bower_components/bootstrap/dist/js/bootstrap.min",
		"metisMenu": "../../startbootstrap-sb-admin-2-1.0.7/bower_components/metisMenu/dist/metisMenu.min",
		"jquery_dataTables": "../../startbootstrap-sb-admin-2-1.0.7/bower_components/datatables/media/js/jquery.dataTables.min",
		"dataTables_bootstrap": "../../startbootstrap-sb-admin-2-1.0.7/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min",
		"sb_admin_2": "../../startbootstrap-sb-admin-2-1.0.7/dist/js/sb-admin-2",
		"md5": "../md5",
		"common": "../common"
    },
	shim: {
		"jquery_ui": [ "jquery" ],
		"bootstrap": [ "jquery" ],
		"metisMenu": [ "jquery", "bootstrap" ],
		"jquery_dataTables": [ "jquery" ],
		"dataTables_bootstrap": [ "jquery_dataTables", "bootstrap" ],
		"sb_admin_2": [ "jquery", "metisMenu" ],		
		"common": [ "jquery_ui" ]
	}
});

require(
	[ "jquery", "jquery_ui", "bootstrap", "metisMenu", "jquery_dataTables", "dataTables_bootstrap", "sb_admin_2", "md5", "common" ], 
	function($) {
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
