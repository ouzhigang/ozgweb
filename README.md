ckeditor需要自行下载，然后放到/ozgweb/ckeditor/，在/ozgweb/ckeditor/config.js的CKEDITOR.editorConfig里面加入config.filebrowserImageUploadUrl = "upload.php?act=ckupload";

默认网站目录为/ozgweb/，改变网站目录的话需要修改config.php中的WEB_PATH

后台路径是/ozgweb/admin，用户密码都是admin

数据库使用sqlite3，路径为/ozgweb/ozgweb.php
