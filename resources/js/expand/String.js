// Unicodeת��
String.prototype.ascW = function()
{
	var strText = "";
	for (var i=0; i<this.length; i++) {
		strText += "&#" + this.charCodeAt(i) + ";";
	}
	return strText;
} 

// HTML����
String.prototype.HTMLEncode = function()
{
	var re = this;
	var q1 = [/x26/g,/x3C/g,/x3E/g,/x20/g];
	var q2 = ["&","<",">"," "];
	for(var i=0;i<q1.length;i++)
	re = re.replace(q1[i],q2[i]);
	return re;
} 

// �õ��ֽڳ���
String.prototype.getRealLength = function()
{
	return this.replace(/[^x00-xff]/g,"--").length;
}

// �����ȡָ�����ȵ��ִ�
String.prototype.left = function(n)
{
	return this.slice(0,n);
}

// ���ҽ�ȡָ�����ȵ��ִ�
String.prototype.right = function(n)
{
	return this.slice(this.length-n);
} 

// ��ȥ���߿հ�
String.prototype.trim = function()
{
	return this.replace(/(^s+)|(s+$)/g,"");
}

// ��������
String.prototype.getNum = function()
{
	return this.replace(/[^d]/g,"");
}

// ������ĸ
String.prototype.getEn = function()
{
	return this.replace(/[^A-Za-z]/g,"");
}

// ��������
String.prototype.getCn = function()
{
	return this.replace(/[^u4e00-u9fa5uf900-ufa2d]/g,"");
} 

//�����Ƿ�������
String.prototype.IsNumeric=function()
{
	var tmpFloat=parseFloat(this);
	if(isNaN(tmpFloat)) return false;
	var tmpLen=this.length-tmpFloat.toString().length;
	return tmpFloat+"0".Repeat(tmpLen)==this;
}

//�����Ƿ�������
String.prototype.IsInt=function()
{
	if(this=="NaN") return false;
	return this==parseInt(this).toString();
}

// �ϲ�����հ�Ϊһ���հ�
String.prototype.resetBlank = function()
{
	return this.replace(/s+/g," ");
}

// ��ȥ��߿հ�
String.prototype.LTrim = function()
{
	return this.replace(/^s+/g,"");
}

// ��ȥ�ұ߿հ�
String.prototype.RTrim = function()
{
	return this.replace(/s+$/g,"");
} 

//��ȡ�ַ�����
String.prototype.ToCharArray=function()
{
	return this.split("");
}

//��ȡN����ͬ���ַ���
String.prototype.Repeat=function(num)
{
	var tmpArr=[];
	for(var i=0;i<num;i++) tmpArr.push(this);
	return tmpArr.join("");
}

//����
String.prototype.Reverse=function()
{
	return this.split("").reverse().join("");
} 

//���ַ���������ĸת��Ϊ��д
String.prototype.initialsToUpper = function() {  
	return this.substring(0,1).toUpperCase().concat(this.substring(1));  
}  


//�ַ���֤
//��֤�Ƿ�Ϊ�Ϸ����ֻ�����  
String.prototype.isMobile = function() {   
	return /^(?:13\d|15[89])-?\d{5}(\d{3}|\*{3})$/.test(this.trim());   
}
   
//��֤�Ƿ�Ϊ�Ϸ��ĵ绰�������  
String.prototype.isPhone = function() {   
	return /^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$/.test(this.trim());   
}
   
//��֤�Ƿ�Ϊ�Ϸ���Email  
String.prototype.isEmail = function() {  
	return /^[a-zA-Z0-9_\-]{1,}@[a-zA-Z0-9_\-]{1,}\.[a-zA-Z0-9_\-.]{1,}$/.test(this.trim());  
}
   
//��֤�Ƿ�Ϊ�Ϸ����ʱ�  
String.prototype.isPost = function() {  
	return /^\d{6}$/.test(this.trim());  
}
   
//��֤�Ƿ�Ϊ�Ϸ�����ַ  
String.prototype.isUrl = function() {  
	var strRegex = "^((https|http|ftp|rtsp|mms)://)"    
	+ "(([0-9a-z_!~*��().&=+$%-]+: )?[0-9a-z_!~*��().&=+$%-]+@)?" //��֤ftp��user@    
	+ "(([0-9]{1,3}\.){3}[0-9]{1,3}" // ��֤IP��ʽ��URL    
	+ "|" // ����IP�� DOMAIN��������    
	+ "([0-9a-z_!~*��()-]+\.)*" // ����- www.    
	+ "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\." // ��������    
	+ "[a-z]{2,6})" // һ������    
	+ "(:[0-9]{1,4})?" // �˿�        
	var re = new RegExp(strRegex);    
	return re.test(this.trim());  
}

//�ж��ַ��Ƿ�����˸��ַ�
String.prototype.contains=function(s){
	if(this.indexOf(s)>=0){
		//����
		return true;
	}
	else{
		//������
		return false;
	}
}
