<?php
/*
include("runtime.php");
$runtime=new runtime();
$runtime->start();
$runtime->stop();
echo("页面执行时间: ".$runtime->spent()." 毫秒");
*/

class Runtime {
    var $StartTime = 0;
    var $StopTime = 0;
 
    function get_microtime() {
        list($usec, $sec) = explode(' ', microtime());
        return ((float)$usec + (float)$sec);
    }
 
    function start() {
        $this->StartTime = $this->get_microtime();
    }
 
    function stop() {
        $this->StopTime = $this->get_microtime();
    }
 
    function spent() {
        return round(($this->StopTime - $this->StartTime) * 1000, 1);
    }
 
}
