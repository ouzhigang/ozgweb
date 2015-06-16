
require(
	[ "config" ], 
	function () {
		require([ "admin.dataclass_list" ]);
	}), 
	define("admin.dataclass_list", [ "jquery", "jquery_ui", "bootstrap", "metisMenu", "sb_admin_2", "md5", "common" ], function ($) {
		page_init();
		
		$(".list-unstyled > li").mouseover(function() {			
			$(this).css("background-color", "#F5F5F0");
		});
		$(".list-unstyled > li").mouseout(function() {			
			$(this).css("background-color", "#FFFFFF");
		});
	}
);
