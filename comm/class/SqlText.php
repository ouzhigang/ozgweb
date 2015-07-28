<?php

class SqlText {
	//适用MYSQL
	
	//----获取select SQL语句----
	//$clomuns(string)为目标列
	//$table(string)为目标表
	//$where(string)为查询条件(可传入null)
	//$order(string)为排序(可传入null)
	//$top(int)显示指定记录数
	static function selectMysql($cloumns, $table, $where, $order, $top) {
		$sql = "select " . $cloumns . " from " . $table;
		if(!empty($where)) {
			$sql .= " where " . $where;
		}
		if(!empty($order)) {
			$sql .= " order by " . $order;	
		}		

		if(!empty($top)) {
			$sql .= " limit " . $top;
		}
		return $sql;
	}

	//----获取select SQL语句----
	//$clomuns(string)为目标列 mssql分页要使用这样("*||id"),后面那个id为分页主键
	//$table(string)为目标表
	//$where(string)为查询条件(可传入null)
	//$order(string)为排序,如：table.id desc   (可传入null)
	//$pageindex(int)为当前页
	//$pagesize(int)为每页显示记录
	static function selectMysqlPage($cloumns, $table, $where, $order, $pageindex, $pagesize) {
		//limit是简单解决方案，但是数据量大的时候不适合！
		/*		
		$sql = "select " . $cloumns . " from " . $table;
		if(!empty($where)) {
			$sql .= " where " . $where;
		}
		if(!empty($order)) {
			$sql .= " order by " . $order;	
		}				
		$startindex = ($pageindex - 1) * $pagesize;
		$sql .= " limit " . $startindex . ", " . $pagesize;
		return $sql;	
		*/
		
		//高效查询
		//组合一个分类的实例：
		//select * from ozgphp_data AS TmpTableA inner join (select id from ozgphp_data where TYPE=1 order by sort desc,id desc limit 60,30) as TmpTableB on TmpTableA.id=TmpTableB.id,ozgphp_dataclass as TmpTableC where TmpTableC.id=TmpTableA.dataclassid order by TmpTableA.sort desc,TmpTableA.id desc
		
		if(!empty($where)) {
			$where = " where " . $where;
		}
		
		if(!empty($order)) {
			$order = " order by " . $order;
		}
		$keys = explode("||", $cloumns);	
		$startindex = self::getStartIndex($pageindex, $pagesize);
		$sql = "select " . $keys[0] . " from " . $table . " inner join (select " . $keys[1] . " from " . $table . " " . $where . " " . $order . " limit " . $startindex . ", " . $pagesize . ") as tmp on tmp." . $keys[1] . " = " . $table . "." . $keys[1] . " " . $order;
		//echo $sql;
		//exit();
		return $sql;
	}
	
	//----取该ID的（上一条记录）----
	//$columns(string)目标字段
	//$table(string)目标表
	//$id(string)ID字段
	//$value(string)ID字段值
	//$where(string)where查询
	static function recordPrevMysql($columns, $table, $id, $value, $where = null) {
		if(!empty($where)) {
			$where = $where . " and";
		}
		return "select " . $columns . " from " . $table . " where " . $where . " " . $id . "<" . $value . " order by " . $id . " desc limit 1";
	}
	
	//----取该ID的（下一条记录）----
	//$columns(string)目标字段
	//$table(string)目标表
	//$id(string)ID字段
	//$value(string)ID字段值
	//$where(string)where查询
	static function recordNextMysql($columns, $table, $id, $value, $where = null) {
		if(!empty($where)) {
			$where = $where . " and";
		}
		return "select " . $columns . " from " . $table . " where " . $where . " " . $id . ">" . $value . " order by " . $id . " asc limit 1";
	}
	
	//以下适用MSSQL
	
	//----获取select SQL语句----
	//$clomuns(string)为目标列
	//$table(string)为目标表
	//$where(string)为查询条件(可传入null)
	//$order(string)为排序(可传入null)
	//$top(int)显示指定记录数
	static function select($cloumns, $table, $where, $order, $top) {
		if(!empty($top)) {
			$sql .= " top " . $top;
		}
		
		if(!empty($where)) {
			$where1 = " where " . $where;
		}
		
		if(!empty($order)) {
			$order = " order by " . $order;
		}
		
		if(!empty($top)) {
			$sql = "select top " . $top . " " . $cloumns . " from " . $table . $where1 . $order;
		}
		else {
			$sql = "select " . $cloumns . " from " . $table . $where1 . $order;
		}
		return $sql;
	}
	
	//----获取select SQL语句----
	//$clomuns(string)为目标列 mssql分页要使用这样("*,id"),后面那个id为分页主键
	//$table(string)为目标表
	//$where(string)为查询条件(可传入null)
	//$order(string)为排序(可传入null)
	//$pageindex(int)为当前页
	//$pagesize(int)为每页显示记录
	static function selectPage($cloumns, $table, $where, $order, $pageindex, $pagesize) {
		if(!empty($top)) {
			$sql .= " top " . $top;
		}
		
		if(!empty($where)) {
			$where1 = " where " . $where;
			$where2 = " and " . $where;
		}
		
		if(!empty($order)) {
			$order = " order by " . $order;
		}
		
		$keys = explode(",", $cloumns);	
		$startIndex = self::getStartIndex($pageindex, $pagesize);
		if($startIndex != 0) {
			$sql = "select top " . $pagesize . " " . $keys[0] . " from " . $table . " where " . $keys[1] . " not in (select top " . $startIndex . " " . $keys[1] . " from " . $table . " " . $where1 . " " . $order . ") " . $where2 . " " . $order;			
		}
		else {
			$sql = "select top " . $pagesize . " " . $keys[0] . " from ".$table . " " . $where1 . " " . $order;
		}
		return $sql;
	}
	
	//----取该ID的（上一条记录）----
	//$columns(string)目标字段
	//$table(string)目标表
	//$id(string)ID字段
	//$value(string)ID字段值
	//$where(string)where查询
	static function recordPrev($columns, $table, $id, $value, $where = null) {
		if(!empty($where)) {
			$where = $where . " and";
		}
		return "select top 1 " . $columns . " from " . $table . " where " . $where . " " . $id . "<" . $value . " order by " . $id . " desc";
	}
	
	//----取该ID的（下一条记录）----
	//$columns(string)目标字段
	//$table(string)目标表
	//$id(string)ID字段
	//$value(string)ID字段值
	//$where(string)where查询
	static function recordNext($columns, $table, $id, $value, $where = null) {
		if(!empty($where)) {
			$where = $where . " and";
		}
		return "select top 1 " . $columns . " from " . $table . " where " . $where . " " . $id . ">" . $value . " order by " . $id . " asc";
	}
	
	//以下是通用
	
	//----获取有count max min之类的 SQL语句----
	//$func(string)为sql函数
	//$key(string)为目标字段
	//$table(string)为目标表
	//$where(string)为查询条件
	static function func($func, $key, $table, $where) {
		/*
		if(empty($key)) {
			$key = "*";
		}
		*/
		$sql = "select " . $func . "(" . $key . ") from " . $table;
		
		if(!empty($where)) {
			$sql .= " where " . $where;
		}
		return $sql;
	}
	
	//----获取insert SQL语句----
	//$table(string)为目标表
	//$dataList(array)
	static function insert($table, $dataList) {
		
		$Key = "";
		$Value = "";
		
		$i = 0;
		foreach($dataList as $key => $value) {
			if(is_string($value)) {
				$val = "'" . $value . "'";
			}
			else {
				$val = $value;
			}
		
			if($i != count($dataList) - 1) {
				$Key .= $key . ", ";
				$Value .= $val . ", ";
			}
			else {
				$Key .= $key;
				$Value .= $val;
			}
			$i++;
		}	
		return "insert into " . $table . " (" . $Key . ") values(" . $Value . ")";		
	}	
	
	//----获取update SQL语句----
	//$table(string)为目标表
	//$dataList(array)
	//$where(string)为查询条件
	static function update($table, $dataList, $where) {
		$i = 0;
		$strList = "";
		foreach($dataList as $key => $value) {
			if(is_string($value)) {
				$val = "'" . $value . "'";
			}
			else {
				$val = $value;
			}
						
			if($i != count($dataList) - 1) {
				$strList .= $key . " = " . $val . ", ";
			}
			else {
				$strList .= $key . " = " . $val;
			}
			$i++;
		}
		return "update " . $table . " set " . $strList . " where " . $where;
	}
	
	//----递增指定字段的值----
	//$key(string)为目标表
	//$value(string)为查询条件
	//$table(string)为目标表
	//$where(string)为查询条件
	static function updateIncremental($key, $value, $table, $where) {
		return "update " . $table . " set " . $key . " = " . $key . " + " . $value . " where " . $where;
	}
	
	//----获取delete SQL语句----
	//$table(string)为目标表
	//$where(string)为查询条件
	static function delete($table, $where) {
		return "delete from " . $table . " where " . $where;
	}		
	
	//获取分页读取数据开始的索引
	//当前页
	//每页显示记录数
	static function getStartIndex($pageindex, $pagesize) {
		return ($pageindex - 1) * $pagesize;
	}
	
}
