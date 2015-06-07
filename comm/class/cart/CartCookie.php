<?php
class CartCookie {
	private $_cartName;
	
	function __construct($cartName = "CartCookie") {
		$this->_cartName = $cartName;
	}
	
	//----获取购物车字符(格式为:产品ID_产品个数,产品ID_产品个数,产品ID_产品个数)----
	function getList() {
		settype($list, "array");
		
		if(!empty($_COOKIE[$this->_cartName])) {
			$tmp_list = explode(",", $_COOKIE[$this->_cartName]);
			for($i = 0; $i < count($tmp_list); $i++) {
				$strs = explode("_", $tmp_list[$i]);
				$list[$strs[0]] = $strs[1];
			}
		}
		
		return $list;
	}
	
	//----添加产品进购物车----
	//$pid(string),产品ID
	//$pnum(string),产品个数
	function add($pid, $pnum) {
		$list = $this->getList();
		$has = $this->has($pid);
		if(!$has) {
			$list[$pid] = $pnum;
			$this->saveCart($list);
		}
		else {
			$tmp = $list[$pid];
			$tmp += $pnum;
			$this->edit($pid, $tmp);
		}
	}
	
	//----删除购物车的产品----
	//$pid(string),产品ID
	function delete($pid) {
		$list=$this->getList();
		$has = $this->has($pid);
		if($has) {
			unset($list[$pid]);
			$this->saveCart($list);
		}
	}
	
	//----清空购物车里面的所有产品----
	function deleteAll() {
		$list = $this->getList();
		foreach($list as $id => $pnum) {
			unset($list[$id]);
		}
		$this->saveCart($list);
	}
	
	//----修改购物车产品的个数----
	//$pid(string),产品ID
	//$pnum(string),产品个数
	function edit($pid, $pnum) {
		$list = $this->getList();
		$has = $this->has($pid);
		if($has) {
			$list[$pid] = $pnum;
			$this->saveCart($list);
		}
	}
	
	//----判断该产品是否存在购物车----
	//$pid(string),产品ID
	function has($pid) {
		$list = $this->getList();
		$has = false;
		foreach($list as $id => $pnum) {
			if($id == $pid) {
				$has = true;
				break;
			}
		}
		return $has;
	}
	
	//----获取购物车产品的总数----
	function getProductsTotal() {
		$list = $this->getList();
		$tmp = 0;
		foreach($list as $id => $pnum) {
			$tmp += $pnum;
		}
		return $tmp;
	}
	
	function getString($cartList) {
		if(count($cartList) >= 0) {
			$tmp = "";
			foreach($cartList as $id => $pnum) {
				$tmp .= $id . "_" . $pnum . ",";
			}
	
			return substr($tmp, 0, strlen($tmp) - 1);
		}
		else
			return "";
	}

	function saveCart($cartList) {
		$toCookie = $this->getString($cartList);
		setcookie($this->_cartName, $toCookie);
	}
	
}
