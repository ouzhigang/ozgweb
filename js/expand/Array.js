/*******************************************\
Array ����չ����(2006-8-8)
  This JavaScript was writen by Dron.
  @2003-2008 Ucren.com All rights reserved.
\*******************************************/


// ����ϴ��
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
// ������������
Array.prototype.sortNum = function(f)
{
    if (!f) f=0;
    if (f==1) return this.sort(function(a,b){return b-a;});
    return this.sort(function(a,b){return a-b;});
}
// �����������������
Array.prototype.getMax = function()
{
    return this.sortNum(1)[0];
}
// ��������������С��
Array.prototype.getMin = function()
{
    return this.sortNum(0)[0];
}
// �����һ�γ���ָ��Ԫ��ֵ��λ��
Array.prototype.indexOf = function(o)
{
    for (var i=0; i<this.length; i++) if (this[i]==o) return i;
    return -1;
}
// �Ƴ��������ظ�����
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

//ȥ���������ظ���ֵ
Array.prototype.unique = function() {  
     var data = this || [];  
     var a = {}; // ����һ������javascript�Ķ�����Ե���ϣ����  
     for (var i = 0; i < data.length; i++) {  
         a[data[i]] = true;  //���ñ�ǣ��������ֵ���±꣬�����Ϳ���ȥ���ظ���ֵ  
     }  
     data.length = 0;   
       
     for (var i in a) { //�������󣬰��ѱ�ǵĻ�ԭ������  
         this[data.length] = i;   
     }   
     return data;  
}

//�������Ƿ����
Array.prototype.contains = function(obj) {
    var i = this.length;
    while (i--) {
        if (this[i] === obj) {
            return true;
        }
    }
    return false;
}

//ɾ�������Ԫ�أ��������������
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

//ɾ�������Ԫ�أ��������ֵ
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
