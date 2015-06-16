
var alert_dialog = null;

require(
	[ "config" ], 
	function () {
		require([ "admin.admin_add" ]);
	}), 
	define("admin.admin_add", [ "jquery", "jquery_ui", "jquery_validate", "bootstrap", "metisMenu", "sb_admin_2", "md5", "common" ], function ($) {
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
