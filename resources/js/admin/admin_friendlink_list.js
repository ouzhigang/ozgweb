
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
		
		//dialog
		var alert_dialog = ready_alert_dialog();
		
		$("#btnadd").click(function() {
			location.href = "admin_friendlink.php?act=add";
		});
		$("button[id^='btnedit_']").click(function() {
			location.href = "admin_friendlink.php?" + $(this).attr("req-data");
		});
		$("button[id^='btndel_']").click(function() {
			var btndel = $(this);
			var conform_dialog = ready_confirm_dialog(function() {
				$.ajax({
					url: "admin_friendlink.php",
					type: "get",
					dataType: "json",
					data: btndel.attr("req-data"),
					beforeSend: function() {
						btndel.attr("disabled", true);
					},
					success: function(res, status) {
						if(res.code == 0) {
							
							btndel.parent().parent().remove();
						}
						else {							
							$("#dialog_message").html(res.desc);
							alert_dialog.dialog("open");
						}
					},
					complete: function() {
						conform_dialog.dialog("close");
					}
				});
			});
			$("#dialog_message").html("确定删除吗？");
			conform_dialog.dialog("open");
			conform_dialog.parent().prev().css('z-index', 9998);
			conform_dialog.parent().css('z-index', 9999);
		});
		
	}
);
