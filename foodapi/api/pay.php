<?php
include_once("../config/init.php");

$action = isset($_GET['action']) ? $_GET['action'] : '';

if($action == "paylist")
{
  $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;

  $user = $db->select()->from("user")->where("id = $userid")->find();

  if(!$user)
  {
    return json('用户不存在');
  }

  $paylist = $db->select()->from('pay')->where("userid = $userid")->orderBy("id",'desc')->all();

  return json('查询充值记录',true,$paylist);
}else if($action == "paydel")
{
  $payid = isset($_POST['payid']) ? $_POST['payid'] : 0;

  if($db->delete("pay","id = $payid"))
  {
    return json('删除成功',true);
  }else{
    return json('删除失败');
  }
}else if($action == 'payadd')
{
  $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;

  $user = $db->select()->from('user')->where("id = $userid")->find();

  if(!$user)
  {
    return json('用户不存在');
  }

  $data = [
    'price'=>(float)($_POST['price']),
    'userid'=>$userid,
    'createtime'=>time()
  ];

  if($db->add("pay",$data))
  {
    return json('添加成功请等待管理员审核',true);
  }else{
    return json('添加失败，请重新添加');
  }
}


?>