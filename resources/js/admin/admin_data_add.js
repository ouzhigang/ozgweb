
require(
	[ "config" ], 
	function () {
		require([ "admin.data_add" ]);
	}), 
	define("admin.data_add", [ "jquery", "jquery_ui", "bootstrap", "metisMenu", "sb_admin_2", "ckeditor", "ckeditor_jquery", "common" ], function ($) {
		page_init();
		
		$('#content').ckeditor({ 
			height: '350px' 
		});
	}
);
