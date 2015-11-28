<?php

/*
//使用前需要安装jdk，并下载apktool.jar

$apk = new ApkParser("D:/apktool/apktool-install-windows-r05-ibot/apktool.jar", dirname(__FILE__) . "/aa.apk"); 
//$apk->reDecode(); //清理临时文件后，重新反编译apk
var_dump($apk->getPackage()); //获取apk包名称
var_dump($apk->getVersionName()); //获取apk版本名称
var_dump($apk->getVersionCode()); //获取apk版本代码
var_dump($apk->getActivityNodeList()); //获取Activity的NodeList
var_dump($apk->getPermissionList()); //获取权限列表
var_dump($apk->getMainActivity()); //获取MainActivity的XmlNode
var_dump($apk->getAppName()); //获取apk名称
var_dump($apk->getStringsNodeList()); //获取strings下的NodeList
var_dump($apk->getIcon()); //获取图标路径

*/

class ApkParser {
	
	private $apktool;
	private $apk_file;
	private $outdir;
	private $AndroidManifest;
	private $AndroidManifestXmlDoc;
	private $StringsXmlDoc;
	
	public function __construct($apktool, $apk_file) {
		$apk_info = pathinfo($apk_file);
		
		$this->apktool = $apktool;
		$this->apk_file = $apk_file;
		$this->outdir = $apk_info["dirname"] . "/" . $apk_info["filename"];
		$this->AndroidManifest = $this->outdir . "/AndroidManifest.xml";
		
		$this->decode();
    }	
	
	//清理临时文件后，重新反编译apk
	public function reDecode() {
		$this->deldir($this->outdir);
		$this->decode();		
	}
	
	//获取apk包名称
    public function getPackage() {
		$manifest = $this->AndroidManifestXmlDoc->documentElement;
		return $manifest->getAttribute("package");
    }
    
	//获取apk版本名称
    public function getVersionName() {
		$manifest = $this->AndroidManifestXmlDoc->documentElement;
		return $manifest->getAttribute("android:versionName");
    }
    
	//获取apk版本代码
    public function getVersionCode() {
		$manifest = $this->AndroidManifestXmlDoc->documentElement;
		return $manifest->getAttribute("android:versionCode");
    }
    
	//获取apk名称
    public function getAppName() {
		
		$main_activity = $this->getMainActivity();		
		$app_name = $main_activity->getAttribute("android:label");		
		return $this->getStrings2($app_name);
    }
	
	//获取图标路径
	public function getIcon() {
		$application_node = $this->getApplocationNode();
		
		$drawable_dir = array(
			"drawable-xhdpi",
			"drawable-hdpi",
			"drawable-mdpi",
			"drawable-ldpi",
			"drawable"
		);
		
		$s = explode("/", $application_node->getAttribute("android:icon"));
		$s = $s[0];
		$icon = str_replace($s . "/", "", $application_node->getAttribute("android:icon"));
		
		//搜索图标
		foreach($drawable_dir as $v) {
			$files = $this->getFiles($this->outdir . "/res/" . $v);
			foreach($files as $file) {
				$all_path = $this->outdir . "/res/" . $v . "/" . $file;
				$all_path_info = pathinfo($all_path);
				if($all_path_info["filename"] == $icon) {
					$apk_info = pathinfo($this->apk_file);
					return $apk_info["filename"] . "/res/" . $v . "/" . $all_path_info["basename"];
				}
			}
		}
		
		//return $icon;
		return NULL;
	}
    
	//获取MainActivity的XmlNode
    public function getMainActivity() {
		$list = $this->getActivityNodeList();
		
		for($i = 0; $i < $list->length; $i++) {
			$item = $list->item($i);
			
			if(strtolower($item->nodeName) == "activity") {
				for($j = 0; $j < $item->childNodes->length; $j++) {
					$item2 = $item->childNodes->item($j);
					if(strtolower($item2->nodeName) == "intent-filter") {
						
						for($k = 0; $k < $item2->childNodes->length; $k++) {
							$item3 = $item2->childNodes->item($k);
							
							if(strtolower($item3->nodeName) == "action") {
								
								if($item3->getAttribute("android:name") == "android.intent.action.MAIN") {									
									return $item;									
								}
								
							}
						}
						
					}
				}
			}
			
		}
		
		return NULL;
    }
    
	//获取application的XmlNode
	public function getApplocationNode() {
		$application_node = NULL;		
		$list = $this->AndroidManifestXmlDoc->documentElement->childNodes;
		for($i = 0; $i < $list->length; $i++) {
			$item = $list->item($i);
			if(strtolower($item->nodeName) == "application") {
				$application_node = $item;
				break;
			}
		}
		
		//test
		/*for($i = 0; $i < $application_node->childNodes->length; $i++) {
			$item = $application_node->childNodes->item($i);
			var_dump($item->nodeName);
		}*/
		
		return $application_node;
	}
	
	//获取Activity的NodeList
    public function getActivityNodeList() {
		$application_node = $this->getApplocationNode();
		if($application_node)
			return $application_node->childNodes;
		return NULL;
    }
	
	//获取strings下的NodeList
	public function getStringsNodeList() {
		$strings_node_list = $this->StringsXmlDoc->documentElement->childNodes;		
		return $strings_node_list;
	}
	
	//获取一个strings的值，如getStrings("app_name")
	public function getStrings($name) {
		$strings_node_list = $this->getStringsNodeList();
		for($i = 0; $i < $strings_node_list->length; $i++) {
			$item = $strings_node_list->item($i);
			if(strtolower($item->nodeName) == "string" && strtolower($item->getAttribute("name")) == $name)
				return $item->nodeValue;
		}
		return NULL;
	}
	
	//获取一个strings的值，如getStrings2("@string/app_name")
	public function getStrings2($name) {
		$s = explode("/", $name);
		$s = $s[0];
		
		return $this->getStrings(str_replace($s . "/", "", $name));
	}
	
	//获取权限列表
	public function getPermissionList() {
		$permission_list = array();
		
		$manifest = $this->AndroidManifestXmlDoc->documentElement;
		for($i = 0; $i < $manifest->childNodes->length; $i++) {
			$item = $manifest->childNodes->item($i);
			
			if(strtolower($item->nodeName) == "uses-permission") {
				$permission_list[] = $item->getAttribute("android:name");
			}
		}
		
		return $permission_list;
	}
	
	//执行反编译apk
	private function decode() {
		if(!file_exists($this->AndroidManifest)) {
			$cmd = "java -jar " . $this->apktool . " d " . $this->apk_file . " " . $this->outdir;
			exec($cmd);
			
			if(!file_exists($this->AndroidManifest)) {
				throw new Exception("APK decode fail!");
			}
		}
		
		$this->AndroidManifestXmlDoc = new DOMDocument();
		$this->AndroidManifestXmlDoc->load($this->AndroidManifest);
		
		$this->StringsXmlDoc = new DOMDocument();
		$this->StringsXmlDoc->load($this->outdir . "/res/values/strings.xml"); //暂时不支持国际化
	}
	
	//删除一个目录里面的所有文件
	private function deldir($dir) {
		//先删除目录下的文件：
		$dh = opendir($dir);
		while ($file = readdir($dh)) {
			if($file != "." && $file != "..") {
				$fullpath = $dir . "/" . $file;
				if(!is_dir($fullpath)) {
					unlink($fullpath);
				} 
				else {
					$this->deldir($fullpath);
				}
			}
		}
 
		closedir($dh);
		//删除当前文件夹：
		if(rmdir($dir)) {
			return true;
		} 
		else {
			return false;
		}
	}
	
	//获取一个目录下的文件列表
	private function getFiles($dir) {
		$FileArray = array();
        if(is_dir($dir)) {  
			if(false != ($handle = opendir($dir))) {  
				while(false != ($file = readdir($handle))) {  
					if($file != '.' && $file != '..' && strpos($file, '.')) {  
						$FileArray[] = $file;  
					}
				}  
				closedir($handle);  
			}  
		}
		else {  
            $FileArray[] = '[Path]:\'' . $dir . '\' is not a dir or not found!';  
        }  
        return $FileArray;  
    }
	
}
