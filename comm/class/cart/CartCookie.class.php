<?php
class CartCookie
{
	private $_CartName;
	
	function CartCookie($CartName="CartCookie")
	{
		$this->_CartName=$CartName;
	}
	
	//----获取购物车字符(格式为:产品ID_产品个数,产品ID_产品个数,产品ID_产品个数)----
	function GetList()
	{
		settype($list,"array");
		
		if(!empty($_COOKIE[$this->_CartName]))
		{
			$tmp_list=explode(",",$_COOKIE[$this->_CartName]);
			for($i=0;$i<count($tmp_list);$i++)
			{
				$strs=explode("_",$tmp_list[$i]);
				$list[$strs[0]]=$strs[1];
			}
		}
		
		return $list;
	}
	
	//----添加产品进购物车----
	//$pid(string),产品ID
	//$pnum(string),产品个数
	function Add($pid, $pnum)
	{
		$list=$this->GetList();
		$has = $this->Has($pid);
		if(!$has)
		{
			$list[$pid]=$pnum;
			$this->SaveCart($list);
		}
		else
		{
			$tmp=$list[$pid];
			$tmp+=$pnum;
			Edit($pid,$tmp);
		}
	}
	
	//----删除购物车的产品----
	//$pid(string),产品ID
	function Delete($pid)
	{
		$list=$this->GetList();
		$has = $this->Has($pid);
		if($has)
		{
			unset($list[$pid]);
			$this->SaveCart($list);
		}
	}
	
	//----清空购物车里面的所有产品----
	function DeleteAll()
	{
		$list=$this->GetList();
		foreach($list as $id=>$pnum)
		{
			unset($list[$id]);
		}
		$this->SaveCart($list);
	}
	
	//----修改购物车产品的个数----
	//$pid(string),产品ID
	//$pnum(string),产品个数
	function Edit($pid,$pnum)
	{
		$list=$this->GetList();
		$has = $this->Has($pid);
		if($has)
		{
			$list[$pid]=$pnum;
			$this->SaveCart($list);
		}
	}
	
	//----判断该产品是否存在购物车----
	//$pid(string),产品ID
	function Has($pid)
	{
		$list=$this->GetList();
		$has=false;
		foreach($list as $id=>$pnum)
		{
			if($id==$pid)
			{
				$has=true;
				break;
			}
		}
		return $has;
	}
	
	//----获取购物车产品的总数----
	function GetProductsTotal()
	{
		$list=$this->GetList();
		$tmp=0;
		foreach($list as $id=>$pnum)
		{
			$tmp+=$pnum;
		}
		return $tmp;
	}
		
	
	
	function GetString($CartList)
	{
		if(count($CartList)>=0)
		{
			$tmp = "";
			foreach ($CartList as $id=>$pnum)
			{
				$tmp .= $id."_".$pnum.",";
			}
	
			return substr($tmp,0,strlen($tmp)-1);
		}
		else
		{
			return "";
		}
	}

	function SaveCart($CartList)
	{
		$toCookie = $this->GetString($CartList);
		setcookie($this->_CartName,$toCookie);
	}
	
}
