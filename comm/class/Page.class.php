<?php
/*

实例：
$p=new Page();
$p->first="首页";
$p->prev="上一页";
$p->next="下一页";
$p->last="末页";
//$p->cssClass="class1";
//$p->query="name=123&pwd=456";
$p->pageSize=2;
$recordCount=$mysql->single("select count(id) from admin");
$p->recordCount=$recordCount[0];
$list=$mysql->read(SqlText::select("*","admin",null,null,$p->pageIndex(),$p->pageSize(),null));
$p->paging();
$p->paging2('pictrue-123-#pageIndex#.html');
*/
class Page
{
	public $cssClass;
	public $pageIndexName="p";
	public $suffix = null;
	public $pageSize=10;
	public $recordCount;
	public $query;
	public $firstText;
	public $prevText;
	public $nextText;
	public $lastText;
	
	//获取第一页的分页导航
	function first()
	{
		return $this->firstText;
	}
	//获取上一页的分页导航
	function prev()
	{
		return $this->prevText;
	}
	//获取下一页的分页导航
	function next()
	{
		return $this->nextText;
	}
	//获取最后一页的分页导航
	function last()
	{
		return $this->lastText;
	}
	
	//获取每页显示记录数
	function pageSize()
	{
		return $this->pageSize;
	}
	
	//获取总页数
	function pageCount()
	{
		if ($this->recordCount() % $this->pageSize() == 0)
		{
			return $this->recordCount() / $this->pageSize();
		}
		else
		{
			return floor($this->recordCount() / $this->pageSize()) + 1;
		}
	}
	
	//获取记录总数
	function recordCount()
	{
		return $this->recordCount;
	}
	
	//获取当前页索引
	function pageIndex()
	{
		if(empty($_GET[$this->pageIndexName]))
		{
			return 1;
		}
		else
		{
			return $_GET[$this->pageIndexName];
		}
	}
	
	//获取当前请求文件
	function self()
	{		
		if(!$this->suffix) {
			return str_replace("/", "", strrchr($_SERVER['PHP_SELF'], "/"));
		}
		else {
			$file_name = str_replace("/", "", strrchr($_SERVER['PHP_SELF'], "/"));
			$extend = explode("." , $file_name);
			$va = count($extend) - 1;  
			return str_replace("." . $extend[$va], $this->suffix, $file_name);
		}
	}
	
	//获取查询字符
	function query()
	{
		if(empty($this->query))
		{
			return "";
		}
		else
		{
			return "&".$this->query;
		}
	}
	
	//分页含含
	function paging()
	{		
		if(!empty($this->recordCount)&&$this->recordCount>0)
		{
			if(!empty($this->cssClass))
			{
				$this->cssClass="class='".$this->cssClass."'";
			}
		
			if($this->pageIndex()>1)
			{
				if(!empty($this->firstText))
				{
					$this->firstText="<a ".$this->cssClass." href='".$this->self()."?".$this->pageIndexName."=1".$this->query()."'>".$this->firstText."</a>";
				}
				if(!empty($this->prevText))
				{
					$this->prevText="<a ".$this->cssClass." href='".$this->self()."?".$this->pageIndexName."=".($this->pageIndex()-1).$this->query()."'>".$this->prevText."</a>";
				}
			}
			else{
				$this->firstText="<a disabled='disabled' href='javascript:void(0)'>".$this->firstText."</a>";
				$this->prevText="<a disabled='disabled' href='javascript:void(0)'>".$this->prevText."</a>";
			}
			
			if ($this->pageIndex() < $this->pageCount())
			{
				if(!empty($this->nextText))
				{
					$this->nextText="<a ".$this->cssClass." href='".$this->self()."?".$this->pageIndexName."=".($this->pageIndex()+1).$this->query()."'>".$this->nextText."</a>";
				}
				if(!empty($this->lastText))
				{
					$this->lastText="<a ".$this->cssClass." href='".$this->self()."?".$this->pageIndexName."=".$this->pageCount().$this->query()."'>".$this->lastText."</a>";
				}
			}
			else{
				$this->nextText="<a disabled='disabled' href='javascript:void(0)'>".$this->nextText."</a>";
				$this->lastText="<a disabled='disabled' href='javascript:void(0)'>".$this->lastText."</a>";
			}
		}
	}
	
	//使用URL重写分页含含
	//$targetUrl:string,目标URL,#pageIndex#为分页索引变量,使用URL重写$query属性将失去作用
	function paging2($targetUrl){
		if(!empty($this->recordCount)&&$this->recordCount>0)
		{
			if(!empty($this->cssClass))
			{
				$this->cssClass="class='".$this->cssClass."'";
			}
		
			if($this->pageIndex()>1)
			{
				if(!empty($this->firstText))
				{
					$url=str_replace("#pageIndex#","1",$targetUrl);
					$this->firstText="<a ".$this->cssClass." href='".$url."'>".$this->firstText."</a>";
				}
				if(!empty($this->prevText))
				{
					$url=str_replace("#pageIndex#",strval($this->pageIndex()-1),$targetUrl);
					$this->prevText="<a ".$this->cssClass." href='".$url."'>".$this->prevText."</a>";
				}
			}
			else{
				$this->firstText="<a disabled='disabled' href='javascript:void(0)'>".$this->firstText."</a>";
				$this->prevText="<a disabled='disabled' href='javascript:void(0)'>".$this->prevText."</a>";
			}
			
			if ($this->pageIndex() < $this->pageCount())
			{
				if(!empty($this->nextText))
				{
					$url=str_replace("#pageIndex#",strval($this->pageIndex()+1),$targetUrl);
					$this->nextText="<a ".$this->cssClass." href='".$url."'>".$this->nextText."</a>";
				}
				if(!empty($this->lastText))
				{
					$url=str_replace("#pageIndex#",strval($this->pageCount()),$targetUrl);
					$this->lastText="<a ".$this->cssClass." href='".$url."'>".$this->lastText."</a>";
				}
			}
			else{
				$this->nextText="<a disabled='disabled' href='javascript:void(0)'>".$this->nextText."</a>";
				$this->lastText="<a disabled='disabled' href='javascript:void(0)'>".$this->lastText."</a>";
			}
		}
	}
	
}
