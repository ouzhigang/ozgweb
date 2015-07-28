
require(
	[ "config" ], 
	function () {
		require([ "admin.admin_list" ]);
	}), 
	define("admin.admin_list", [ "jquery", "jquery_ui", "bootstrap", "metisMenu", "sb_admin_2", "md5", "common" ], function ($) {
		
		page_init();
		
		//dialog
		var alert_dialog = ready_alert_dialog();
		
		//点击删除
		$(".btn-link").click(function() {
			var btndel = $(this);
			var conform_dialog = ready_confirm_dialog(function() {
				$.ajax({
					url: "admin_admin.php",
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
