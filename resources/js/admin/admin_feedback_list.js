
var curr_page = 1;
var page_count = 1;
var alert_dialog;

function show_data(page) {
	
	$.ajax({
		url: "admin_feedback.php",
		type: "get",
		dataType: "json",
		data: "act=getlist&page=" + page,
		beforeSend: function() {
			
		},
		success: function(res, status) {
			if(res.code == 0) {
				
				$("#datalist > tbody").empty();
				for(var i = 0; i < res.data.list.length; i++) {				
					var row = "<tr>";
					row += "<td>" + res.data.list[i].id + "</td>"
					row += "<td>" + res.data.list[i].content + "</td>";
					row += "<td>" + res.data.list[i].add_time + "</td>";
					row += "<td><button class=\"btn btn-outline btn-link\" type=\"button\" id=\"id_" + res.data.list[i].id + "\" req-data=\"act=del&id=" + res.data.list[i].id + "\">删除</button></td>";
					row += "</tr>";
					
					$("#datalist > tbody").append(row);
				}
				
				page = res.data.page;
				page_count = res.data.page_count;				
				$("#page").html(page);
				$("#page_count").html(page_count);
				
				//点击删除
				$("button[id^='id_']").click(function() {
					var btndel = $(this);
					var conform_dialog = ready_confirm_dialog(function() {
						$.ajax({
							url: "admin_feedback.php",
							type: "get",
							dataType: "json",
							data: btndel.attr("req-data"),
							beforeSend: function() {
								btndel.attr("disabled", true);
							},
							success: function(res, status) {
								if(res.code == 0) {
									
									show_data(curr_page);
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
		},
		complete: function() {
			
		}
	});
	
}

require(
	[ "config" ], 
	function () {
		require([ "admin.feedback_list" ]);
	}), 
	define("admin.feedback_list", [ "jquery", "jquery_ui", "bootstrap", "metisMenu", "sb_admin_2", "md5", "common" ], function ($) {
		page_init();
		
		//dialog
		alert_dialog = ready_alert_dialog();
		
		show_data(curr_page);		
		$("#page_first").click(function() {
			curr_page = 1;		
			show_data(curr_page);	
		});
		$("#page_prev").click(function() {
			curr_page--;
			if(curr_page < 1)
				curr_page = 1;
			show_data(curr_page);	
		});
		$("#page_next").click(function() {
			curr_page++;
			if(curr_page > page_count)
				curr_page = page_count;
			show_data(curr_page);
		});
		$("#page_last").click(function() {
			curr_page = page_count;		
			show_data(page_count);	
		});
	}
);
