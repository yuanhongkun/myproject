<?php

include_once("extends/securityCode.php");


//实例化一个验证码类
$imgcode = new securityCode();

//显示验证码效果
$imgcode->showImage(205,155,29);
?>