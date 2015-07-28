
require(
	[ "config" ], 
	function () {
		require([ "admin.admin_index" ]);
	}), 
	define("admin.admin_index", [ "jquery", "jquery_ui", "bootstrap", "metisMenu", "sb_admin_2", "common" ], function ($) {
		
		page_init();
	}
);
