
//后台js配置

require.config({
    paths: {
        "jquery": "http://libs.useso.com/js/jquery/2.1.1/jquery.min",
		"jquery_ui": "http://libs.useso.com/js/jqueryui/1.10.4/jquery-ui.min",
		"jquery_validate": "http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min",
		"bootstrap": "../../startbootstrap-sb-admin-2-1.0.7/bower_components/bootstrap/dist/js/bootstrap.min",
		"metisMenu": "../../startbootstrap-sb-admin-2-1.0.7/bower_components/metisMenu/dist/metisMenu.min",		
		"sb_admin_2": "../../startbootstrap-sb-admin-2-1.0.7/dist/js/sb-admin-2",
		"ckeditor": "../../../ckeditor/ckeditor",
		"ckeditor_jquery": "../../../ckeditor/adapters/jquery",
		"md5": "../md5",
		"common": "../common"
    },
	shim: {
		"jquery_ui": [ "jquery" ],
		"jquery_validate": [ "jquery" ],
		"bootstrap": [ "jquery" ],
		"metisMenu": [ "jquery", "bootstrap" ],
		"sb_admin_2": [ "jquery", "metisMenu" ],
		"ckeditor_jquery": [ "jquery", "ckeditor" ],
		"common": [ "jquery", "jquery_ui" ]
	}
});
