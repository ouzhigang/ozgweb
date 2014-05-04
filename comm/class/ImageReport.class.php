<?php
class ImageReport{
	
	var $X;//图片大小X轴
	var $Y;//图片大小Y轴
	var $R;//背影色R值
	var $G;//...G.
	var $B;//...B.
	var $TRANSPARENT;//是否透明1或0
	var $IMAGE;//图片对像
	//-------------------
	var $ARRAYSPLIT;//指定用于分隔数值的符号
	var $ITEMARRAY;//数值
	var $REPORTTYPE;//图表类型,1为竖柱形2为横柱形3为折线形
	var $BORDER;//距离
	//-------------------
	var $FONTSIZE;//字体大小
	var $FONTCOLOR;//字体颜色
	
	//--------参数设置函数 (背景图像的)
	function setImage($SizeX,$SizeY,$R,$G,$B,$Transparent){
		$this->X=$SizeX; 
		$this->Y=$SizeY; 
		$this->R=$R; 
		$this->G=$G; 
		$this->B=$B; 
		$this->TRANSPARENT=$Transparent; 
	} 
	
	function setItem($ArraySplit,$ItemArray,$ReportType,$Border){ 
		$this->ARRAYSPLIT=$ArraySplit; 
		$this->ITEMARRAY=$ItemArray; 
		$this->REPORTTYPE=$ReportType; 
		$this->BORDER=$Border; 
	} 
	
	function setFont($FontSize){ 
		$this->FONTSIZE=$FontSize; 
	} 
	
	
	//----------------主体 
	//根据给的参数
	function PrintReport(){ 
		header("Content-type: image/png"); 
		//建立画布大小 
		$this->IMAGE=imagecreate($this->X,$this->Y); 
		//设定画布背景色 
		$background=imagecolorallocate($this->IMAGE,$this->R,$this->G,$this->B); 
		
		//背影透明与否
		if($this->TRANSPARENT=="1"){ 
			imagecolortransparent($this->IMAGE,$background); 
		}
		else{ 
			//如不要透明时可填充背景色 
			imagefilledrectangle($this->IMAGE,0,0,$this->X,$this->Y,$background); 
		} 
		
		//参数字体大小及颜色 
		$this->FONTCOLOR=imagecolorallocate($this->IMAGE,255-$this->R,255-$this->G,255-$this->B);
		
		//根据REPORTTYPE选择是竖柱状、横柱状还是线状
		switch ($this->REPORTTYPE){ 
			case "0": 
			break; 
			case "1": 
			$this->imageColumnS(); 
			break; 
			case "2":
			$this->imageColumnH();
			break; 
			case "3": 
			$this->imageLine(); 
			break; 
		}
		
		//调用print打印xy坐标轴、图片
		$this->printXY(); 
		$this->printAll(); 
	} 
	
	//-----------打印XY坐标轴 
	function printXY(){ 
		//画XY坐标轴
		$color=imagecolorallocate($this->IMAGE,255-$this->R,255-$this->G,255-$this->B); 
		$xx=$this->X/10; 
		$yy=$this->Y-$this->Y/10; 
		imageline($this->IMAGE,$this->BORDER,$this->BORDER,$this->BORDER,$this->Y-$this->BORDER,$color);// y轴
		imageline($this->IMAGE,$this->BORDER,$this->Y-$this->BORDER,$this->X-$this->BORDER,$this->Y-$this->BORDER,$color);// X轴
		//Y轴上刻度 用总长度-段长判断划线位置
		$rulerY=$this->Y-$this->BORDER; 
		while($rulerY>$this->BORDER*2){ 
			$rulerY=$rulerY-$this->BORDER; 
			imageline($this->IMAGE,$this->BORDER,$rulerY,$this->BORDER-2,$rulerY,$color);  //刻度是在y轴的外侧(左侧)而不是内侧
		} 
	
		//X轴上刻度 用段长+段长<总长度判断划线位置
		$rulerX = '';
		//$rulerX=$rulerX+$this->BORDER;
		$rulerX = $this->BORDER;
		while($rulerX<($this->X-$this->BORDER*2)){ 
			$rulerX=$rulerX+$this->BORDER; 
			//imageline($this->IMAGE,$this->BORDER,10,$this->BORDER+10,10,$color); 
			imageline($this->IMAGE,$rulerX,$this->Y-$this->BORDER,$rulerX,$this->Y-$this->BORDER+2,$color);  //刻度也在外沿(x轴下面)
		} 
	} 
	
	//--------------竖柱形图 
	function imageColumnS(){ 
		$item_array=split($this->ARRAYSPLIT,$this->ITEMARRAY); 
		$num=count($item_array); 
		$item_max=0; 
		for ($i=0;$i<$num;$i++){
			$item_max=max($item_max,$item_array[$i]);
		}
		$xx=$this->BORDER*2; 
		//画柱形图 
		for ($i=0;$i<$num;$i++){
			srand((double)microtime()*1000000);
			if($this->R!=255 && $this->G!=255 && $this->B!=255){ 
				$R=rand($this->R,200); 
				$G=rand($this->G,200); 
				$B=rand($this->B,200); 
			}
			else{ 
				$R=rand(50,200); 
				$G=rand(50,200); 
				$B=rand(50,200); 
			} 
			$color=imagecolorallocate($this->IMAGE,$R,$G,$B); 
			//柱形高度 
			//$height=($this->Y-$this->BORDER)-($this->Y-$this->BORDER*2)*($item_array[$i]/$item_max); //原来的语句，不知道为什么这么复杂
			$height = $this->Y-$this->BORDER-$item_array[$i];
			imagefilledrectangle($this->IMAGE,$xx,$height,$xx+$this->BORDER,$this->Y-$this->BORDER,$color); 
			imagestring($this->IMAGE,$this->FONTSIZE,$xx,$height-$this->BORDER,$item_array[$i],$this->FONTCOLOR); 
			//用于间隔 
			$xx=$xx+$this->BORDER*2; 
		} 
	} 
	
	//-----------横柱形图 
	function imageColumnH(){
		$item_array=split($this->ARRAYSPLIT,$this->ITEMARRAY); 
		$num=count($item_array); 
		$item_max=0; 
		for ($i=0;$i<$num;$i++){
			$item_max=max($item_max,$item_array[$i]);
		}
		$yy=$this->Y-$this->BORDER*2; 
		//画柱形图 
		for ($i=0;$i<$num;$i++){
			srand((double)microtime()*1000000);
			if($this->R!=255 && $this->G!=255 && $this->B!=255){ 
				$R=rand($this->R,200); 
				$G=rand($this->G,200); 
				$B=rand($this->B,200); 
			}
			else{ 
				$R=rand(50,200); 
				$G=rand(50,200); 
				$B=rand(50,200); 
			} 
			$color=imagecolorallocate($this->IMAGE,$R,$G,$B); 
			//柱形长度 
			//$leight=($this->X-$this->BORDER*2)*($item_array[$i]/$item_max); //原来的调试显示错的
			$leight = $this->BORDER + $item_array[$i];
			imagefilledrectangle($this->IMAGE,$this->BORDER,$yy-$this->BORDER,$leight,$yy,$color); 
			imagestring($this->IMAGE,$this->FONTSIZE,$leight+2,$yy-$this->BORDER,$item_array[$i],$this->FONTCOLOR); 
			//用于间隔 
			$yy=$yy-$this->BORDER*2; 
		} 
	} 
		
	//--------------折线图 
	function imageLine(){ 
		$item_array=split($this->ARRAYSPLIT,$this->ITEMARRAY); 
		$num=count($item_array); 
		$item_max=0; 
		$xx = $this->BORDER;//如果$xx=0则折线从x=0,y=$item_array(0)坐标点开始画线。
		for ($i=0;$i<$num;$i++){
			$item_max=max($item_max,$item_array[$i]);
		}
		 
		//画柱形图 
		for ($i=0;$i<$num;$i++){
			srand((double)microtime()*1000000);
			if($this->R!=255 && $this->G!=255 && $this->B!=255){ 
				$R=rand($this->R,200); 
				$G=rand($this->G,200); 
				$B=rand($this->B,200); 
			}
			else{ 
				$R=rand(50,200); 
				$G=rand(50,200); 
				$B=rand(50,200); 
			} 
			$color=ImageColorAllocate($this->IMAGE,$R,$G,$B);
			 
			//柱形高度 
			//$height_now=($this->Y-$this->BORDER)-($this->Y-$this->BORDER*2)*($item_array[$i]/$item_max); //原始
			$height_now = $this->Y-$this->BORDER-$item_array[$i];
			
			if($i!="0"){ 
				imageline($this->IMAGE,$xx,$height_next,$xx+$this->BORDER,$height_now,$color); 
			} 
			imagestring($this->IMAGE,$this->FONTSIZE,$xx+$this->BORDER,$height_now-$this->BORDER/2,$item_array[$i],$this->FONTCOLOR); 
			
			$height_next=$height_now;  //原始
			//用于间隔 
			$xx=$xx+$this->BORDER; 
		} 
	} 
	
	//--------------完成打印图形 
	function printAll(){ 
		imagepng($this->IMAGE); 
		imagedestroy($this->IMAGE);
	} 
	
	//--------------调试 
	function debug(){ 
		echo "X:".$this->X."<br>Y:".$this->Y; 
		echo "<br>BORDER:".$this->BORDER; 
		$item_array=split($this->ARRAYSPLIT,$this->ITEMARRAY); 
		$num=count($item_array); 
		echo "<br>数值个数:".$num."<br>数值:"; 
		for ($i=0;$i<$num;$i++){
			echo "<br>".$item_array[$i]; 
		} 
	} 
	
	
} 



//$report=new ImageReport();

// 参数(长,宽,背影色R,G,B,是否透明1或0) 注:setItem()中，样式选择2时    $sizeX与$sizeY对调，原文就只能600，300柱状图显示正常，改称660和330显示就挂了。
//$report->setImage(600,300,255,255,255,1);
//数值,用指定符号隔开 
//$temparray="79,25,100,250,180,200,150,220,200,150,50,25,100,250,180,200,150,220,200,150";
//参数(分隔数值的指定符号,数值变量,样式1为竖柱图2为横柱图3为折线图,距离)
//$report->setItem(',',$temparray,1,20);  
//字体大小1-10  
//$report->setFont(1);
//$report->PrintReport(); 
//$report->debug();//调式之用 
