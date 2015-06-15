
require.config({
    paths: {
        "jquery": "http://libs.useso.com/js/jquery/2.1.1/jquery.min",
		"jquery_ui": "http://libs.useso.com/js/jqueryui/1.10.4/jquery-ui.min",
		"bootstrap": "../../startbootstrap-sb-admin-2-1.0.7/bower_components/bootstrap/dist/js/bootstrap.min",
		"metisMenu": "../../startbootstrap-sb-admin-2-1.0.7/bower_components/metisMenu/dist/metisMenu.min",		
		"sb_admin_2": "../../startbootstrap-sb-admin-2-1.0.7/dist/js/sb-admin-2",
		"ckeditor": "../../../ckeditor/ckeditor",
		"ckeditor_jquery": "../../../ckeditor/adapters/jquery",
		"common": "../common"
    },
	shim: {
		"jquery_ui": [ "jquery" ],
		"bootstrap": [ "jquery" ],
		"metisMenu": [ "jquery", "bootstrap" ],
		"sb_admin_2": [ "jquery", "metisMenu" ],
		"ckeditor_jquery": [ "jquery", "ckeditor" ],
		"common": [ "jquery_ui" ]
	}
});

require(
	[ "jquery", "jquery_ui", "bootstrap", "metisMenu", "sb_admin_2", "ckeditor", "ckeditor_jquery", "common" ], 
	function($) {
		page_init();
		
		//dialog
		var alert_dialog = ready_alert_dialog();
		
		$('#content').ckeditor({ 
			height: '450px' 
		});
		$("#btn_submit").click(function() {
			
			$.ajax({
				url: "admin_articlesingle.php",
				type: "post",
				dataType: "json",
				data: "act=update&id=" + $("#id").val() + "&content=" + CKEDITOR.instances.content.getData(),
				beforeSend: function() {
					$("#btn_submit").attr("disabled", true);
				},
				success: function(res, status) {
					
					$("#dialog_message").html(res.desc);
					alert_dialog.dialog("open");
				},
				complete: function() {
					$("#btn_submit").attr("disabled", false);
				}
			});
			
		});
		
	}
);
