
function show_picture_row(is_picture_val) {
	
	if(is_picture_val == 1) {
		$("#picture").parent().parent().show();
	}
	else {
		$("#picture").parent().parent().hide();
	}
}

require.config({
    paths: {
        "jquery": "http://libs.useso.com/js/jquery/2.1.1/jquery.min",
		"jquery_ui": "http://libs.useso.com/js/jqueryui/1.10.4/jquery-ui.min",
		"jquery_validate": "http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min",
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
		"jquery_validate": [ "jquery" ],
		"bootstrap": [ "jquery" ],
		"metisMenu": [ "jquery", "bootstrap" ],
		"jquery_dataTables": [ "jquery" ],
		"dataTables_bootstrap": [ "jquery_dataTables", "bootstrap" ],
		"sb_admin_2": [ "jquery", "metisMenu" ],		
		"common": [ "jquery_ui" ]
	}
});

require(
	[ "jquery", "jquery_ui", "jquery_validate", "bootstrap", "metisMenu", "jquery_dataTables", "dataTables_bootstrap", "sb_admin_2", "md5", "common" ], 
	function($) {
		page_init();
		
		//dialog
		alert_dialog = ready_alert_dialog();
		
		$("input[name='is_picture']").change(function() {
			show_picture_row($(this).val());
		});
		show_picture_row($("input[name='is_picture']:checked").val());
		
		$("#main_form").validate({
			rules: {
				name: {
					required: true
				},
				sort: {
					required: true,
					digits: true
				},
				url: {
					required: true,
					url:true
				},
				picture: {
					url:true
				}
			},
			messages: {
				name: {
					required: "没有填写名称"
				},
				sort: {
					required: "没有填写排序",
					digits: "请输入整数"
				},
				url: {
					required: "没有填写URL",
					url: "没有填写正确的URL"
				},
				picture: {
					url: "没有填写正确的URL"
				}
			},
			submitHandler: function(form) {
								
				$.ajax({
					url: "admin_friendlink.php",
					type: "get",
					dataType: "json",
					data: "act=addsubmit&" + $(form).serialize(),
					beforeSend: function() {
						$("#btn_submit").attr("disabled", true);
					},
					success: function(res, status) {
						if(res.code == 0) {
							
							location.href = "admin_friendlink.php";
						}
						else {
							$("#dialog_message").html(res.desc);
							alert_dialog.dialog("open");
						}
					},
					complete: function() {
						$("#btn_submit").attr("disabled", false);
					}
				});
				
			}
		});
		
	}
);
