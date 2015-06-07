/*******************************************\
Array 的扩展方法(2006-8-8)
  This JavaScript was writen by Dron.
  @2003-2008 Ucren.com All rights reserved.
\*******************************************/


// 数组洗牌
Array.prototype.random = function()
{
    var nr=[], me=this, t;
    while(me.length>0)
    {
        nr[nr.length] = me[t = Math.floor(Math.random() * me.length)];
        me = me.del(t);
    }
    return nr;
}
// 数字数组排序
Array.prototype.sortNum = function(f)
{
    if (!f) f=0;
    if (f==1) return this.sort(function(a,b){return b-a;});
    return this.sort(function(a,b){return a-b;});
}
// 获得数字数组的最大项
Array.prototype.getMax = function()
{
    return this.sortNum(1)[0];
}
// 获得数字数组的最小项
Array.prototype.getMin = function()
{
    return this.sortNum(0)[0];
}
// 数组第一次出现指定元素值的位置
Array.prototype.indexOf = function(o)
{
    for (var i=0; i<this.length; i++) if (this[i]==o) return i;
    return -1;
}
// 移除数组中重复的项
Array.prototype.removeRepeat=function()
{
this.sort();
    var rs = [];
    var cr = false;
    for (var i=0; i<this.length; i++)
    {
        if (!cr) cr = this[i];
        else if (cr==this[i]) rs[rs.length] = i;
        else cr = this[i];
    }
    var re = this;
    for (var i=rs.length-1; i>=0; i--) re = re.del(rs[i]);
    return re;
} 

//去掉数组中重复的值
Array.prototype.unique = function() {  
     var data = this || [];  
     var a = {}; // 声明一个对象，javascript的对象可以当哈希表用  
     for (var i = 0; i < data.length; i++) {  
         a[data[i]] = true;  //设置标记，把数组的值当下标，这样就可以去掉重复的值  
     }  
     data.length = 0;   
       
     for (var i in a) { //遍历对象，把已标记的还原成数组  
         this[data.length] = i;   
     }   
     return data;  
}

//检查对象是否存在
Array.prototype.contains = function(obj) {
    var i = this.length;
    while (i--) {
        if (this[i] === obj) {
            return true;
        }
    }
    return false;
}

//删除数组的元素，输入的是索引号
Array.prototype.removeAt=function(dx)
{
    if(isNaN(dx)||dx>this.length){return false;}
    for(var i=0,n=0;i<this.length;i++)
    {
        if(this[i]!=this[dx])
        {
            this[n++]=this[i];
        }
    }
    this.length-=1;
} 

//删除数组的元素，输入的是值
Array.prototype.remove=function(val){
    if(val==""||val==null){
        return false;
    }
    
    for(var i=0;i<this.length;i++){
        if(this[i]==val){
            this.splice(i,1); 
            break;
        }
    }
    
}
