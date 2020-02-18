<?php
header("Content-Type:text/html;charset=utf-8");
session_start();  //开启session会话
header("Access-Control-Allow-Origin: *"); //请求头
//在php5的版本里面有一个魔术方法 __autoload

//自动加载函数 自动触发 当实例化一个类的时候 这个类不存在然后就会触发
function __autoload($classname)
{
  include_once("extends/$classname.php");
}

//实例化一个数据库类
$db = new DB("localhost","root","root","vuefood");


//实例化一个字符串类
$randstr = new RandString();

//辅助函数
include_once('helpers.php');
?>