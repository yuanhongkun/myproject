<?php
header("Content-Type:text/html;charset=utf-8");
include_once('init.php');

if($_POST)
{ 
	$action = isset($_POST['action']) ? $_POST['action'] : "";
	$provinceid = isset($_POST['provinceid']) ? $_POST['provinceid'] : 0;
	$cityid = isset($_POST['cityid']) ? $_POST['cityid'] : 0;

	//选择省 获取市
	if($action == "city")
	{
		$citylist = $db->select()->from("region")->where("parent_id = $provinceid")->all();
		echo json_encode($citylist);
		exit;
	}else if($action == "area"){
		//选择市 获取区域
		$arealist = $db->select()->from("region")->where("parent_id = $cityid")->all();

		echo json_encode($arealist);
		exit;
	}
}


?>