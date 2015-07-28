// Unicode转化
String.prototype.ascW = function()
{
	var strText = "";
	for (var i=0; i<this.length; i++) {
		strText += "&#" + this.charCodeAt(i) + ";";
	}
	return strText;
} 

// HTML编码
String.prototype.HTMLEncode = function()
{
	var re = this;
	var q1 = [/x26/g,/x3C/g,/x3E/g,/x20/g];
	var q2 = ["&","<",">"," "];
	for(var i=0;i<q1.length;i++)
	re = re.replace(q1[i],q2[i]);
	return re;
} 

// 得到字节长度
String.prototype.getRealLength = function()
{
	return this.replace(/[^x00-xff]/g,"--").length;
}

// 从左截取指定长度的字串
String.prototype.left = function(n)
{
	return this.slice(0,n);
}

// 从右截取指定长度的字串
String.prototype.right = function(n)
{
	return this.slice(this.length-n);
} 

// 除去两边空白
String.prototype.trim = function()
{
	return this.replace(/(^s+)|(s+$)/g,"");
}

// 保留数字
String.prototype.getNum = function()
{
	return this.replace(/[^d]/g,"");
}

// 保留字母
String.prototype.getEn = function()
{
	return this.replace(/[^A-Za-z]/g,"");
}

// 保留中文
String.prototype.getCn = function()
{
	return this.replace(/[^u4e00-u9fa5uf900-ufa2d]/g,"");
} 

//测试是否是数字
String.prototype.IsNumeric=function()
{
	var tmpFloat=parseFloat(this);
	if(isNaN(tmpFloat)) return false;
	var tmpLen=this.length-tmpFloat.toString().length;
	return tmpFloat+"0".Repeat(tmpLen)==this;
}

//测试是否是整数
String.prototype.IsInt=function()
{
	if(this=="NaN") return false;
	return this==parseInt(this).toString();
}

// 合并多个空白为一个空白
String.prototype.resetBlank = function()
{
	return this.replace(/s+/g," ");
}

// 除去左边空白
String.prototype.LTrim = function()
{
	return this.replace(/^s+/g,"");
}

// 除去右边空白
String.prototype.RTrim = function()
{
	return this.replace(/s+$/g,"");
} 

//获取字符数组
String.prototype.ToCharArray=function()
{
	return this.split("");
}

//获取N个相同的字符串
String.prototype.Repeat=function(num)
{
	var tmpArr=[];
	for(var i=0;i<num;i++) tmpArr.push(this);
	return tmpArr.join("");
}

//逆序
String.prototype.Reverse=function()
{
	return this.split("").reverse().join("");
} 

//把字符串的首字母转化为大写
String.prototype.initialsToUpper = function() {  
	return this.substring(0,1).toUpperCase().concat(this.substring(1));  
}  


//字符验证
//验证是否为合法的手机号码  
String.prototype.isMobile = function() {   
	return /^(?:13\d|15[89])-?\d{5}(\d{3}|\*{3})$/.test(this.trim());   
}
   
//验证是否为合法的电话号码或传真  
String.prototype.isPhone = function() {   
	return /^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$/.test(this.trim());   
}
   
//验证是否为合法的Email  
String.prototype.isEmail = function() {  
	return /^[a-zA-Z0-9_\-]{1,}@[a-zA-Z0-9_\-]{1,}\.[a-zA-Z0-9_\-.]{1,}$/.test(this.trim());  
}
   
//验证是否为合法的邮编  
String.prototype.isPost = function() {  
	return /^\d{6}$/.test(this.trim());  
}
   
//验证是否为合法的网址  
String.prototype.isUrl = function() {  
	var strRegex = "^((https|http|ftp|rtsp|mms)://)"    
	+ "(([0-9a-z_!~*’().&=+$%-]+: )?[0-9a-z_!~*’().&=+$%-]+@)?" //验证ftp的user@    
	+ "(([0-9]{1,3}\.){3}[0-9]{1,3}" // 验证IP形式的URL    
	+ "|" // 允许IP和 DOMAIN（域名）    
	+ "([0-9a-z_!~*’()-]+\.)*" // 域名- www.    
	+ "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\." // 二级域名    
	+ "[a-z]{2,6})" // 一级域名    
	+ "(:[0-9]{1,4})?" // 端口        
	var re = new RegExp(strRegex);    
	return re.test(this.trim());  
}

//判断字符是否包含了该字符
String.prototype.contains=function(s){
	if(this.indexOf(s)>=0){
		//存在
		return true;
	}
	else{
		//不存在
		return false;
	}
}
