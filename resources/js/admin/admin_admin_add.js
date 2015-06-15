
var alert_dialog = null;

require.config({
    paths: {
        "jquery": "http://libs.useso.com/js/jquery/2.1.1/jquery.min",
		"jquery_ui": "http://libs.useso.com/js/jqueryui/1.10.4/jquery-ui.min",
		"jquery_validate": "http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min",
		"bootstrap": "../../startbootstrap-sb-admin-2-1.0.7/bower_components/bootstrap/dist/js/bootstrap.min",
		"metisMenu": "../../startbootstrap-sb-admin-2-1.0.7/bower_components/metisMenu/dist/metisMenu.min",		
		"sb_admin_2": "../../startbootstrap-sb-admin-2-1.0.7/dist/js/sb-admin-2",
		"md5": "../md5",
		"common": "../common"
    },
	shim: {
		"jquery_ui": [ "jquery" ],
		"jquery_validate": [ "jquery" ],
		"bootstrap": [ "jquery" ],
		"metisMenu": [ "jquery", "bootstrap" ],
		"sb_admin_2": [ "jquery", "metisMenu" ],		
		"common": [ "jquery_ui" ]
	}
});

require(
	[ "jquery", "jquery_ui", "jquery_validate", "bootstrap", "metisMenu", "sb_admin_2", "md5", "common" ], 
	function($) {
		page_init();
		
		//dialog
		alert_dialog = ready_alert_dialog();
		
		$("#main_form").validate({
			rules: {
				name: {
					required: true,
					minlength: 5
				},
				pwd: {
					required: true,
					minlength: 5,
					equalTo: "#pwd2"
				}
			},
			messages: {
				name: {
					required: "没有填写用户名",
					minlength: $.validator.format("用户名不能小于{0}个字符")
				},
				pwd: {
					required: "没有填写密码",
					minlength: "密码不能小于{0}个字符",
					equalTo: "两次输入密码不一致"
				}
			},
			submitHandler: function(form) {
				
				$("#pwd").val(hex_md5($("#pwd").val()));
				$("#pwd2").val(hex_md5($("#pwd2").val()));
				$.ajax({
					url: "admin_admin.php",
					type: "get",
					dataType: "json",
					data: "act=addsubmit&" + $(form).serialize(),
					beforeSend: function() {
						$("#btn_submit").attr("disabled", true);
					},
					success: function(res, status) {
						if(res.code == 0) {
							
							location.href = "admin_admin.php?act=list";
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
