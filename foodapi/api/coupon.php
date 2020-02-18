<?php
include_once("../config/init.php");

$action = isset($_GET['action']) ? $_GET['action'] : '';
if($action == "couponinfo")
{
  $userid = isset($_POST['userid']) ? $_POST['userid'] : '';
  $state = isset($_POST['state']) ? $_POST['state'] : 0;
  $page = isset($_POST['page']) ? $_POST['page'] : 1;

  $user = $db->select()->from("user")->where("id=$userid")->find();

  if(!$user)
  {
    return json('用户不存在');
  }

  $limit = 10;
  $start = ($page-1)*$limit;
  $couponlist = $db->select()->from("coupon")->where("userid = $userid AND state = '$state'")->orderBy("id",'desc')->limit("$start,$limit")->all();
  //$couponlist = $db->select()->from("coupon")->where("userid=$userid")->all();
  
  if($couponlist)
  {
    return json("优惠券列表",true,$couponlist);
  }else{
    return json("优惠列表获取失败");
  }
}else if($action == "getcouponinfo")
{
  $userid = isset($_POST['userid']) ? $_POST['userid'] : '';
  // $state = isset($_POST['state']) ? $_POST['state'] : 0;
  $page = isset($_POST['page']) ? $_POST['page'] : 1;

  $user = $db->select()->from("user")->where("id=$userid")->find();

  if(!$user)
  {
    return json('用户不存在');
  }

  $limit = 10;
  $start = ($page-1)*$limit;
  $getcouponlist = $db->select()->from("getcoupon")->where("userid = $userid")->orderBy("id",'desc')->limit("$start,$limit")->all();
  //$getcouponlist = $db->select()->from("coupon")->where("userid=$userid")->all();
  
  if($getcouponlist)
  {
    return json("优惠券列表",true,$getcouponlist);
  }else{
    return json("优惠列表获取失败");
  }
}else if($action == "addcouponinfo")
{
 
  $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;
  // $state = isset($_POST['state']) ? $_POST['state'] : 0;
  $getcouponlist = isset($_POST['getcouponlist']) ? $_POST['getcouponlist'] : "";

  $couponid = isset($_POST['couponid']) ? $_POST['couponid'] : 0;
 
  
  foreach($getcouponlist as $item)
  {
    
    if($item['id']==$couponid)
    {
      $data=[
        "name"=>$item['name'],
        "valueDesc"=>$item['menoy'],
        "condition"=>$item['detail'],
        "startAt"=>time(),
        "endAt"=>time()+$item['longtime']*24*60*60,
        "description"=>"全场通用",
        "userid"=>$item['id'],
        "state"=>0,
        "price"=>$item['price']
      ];
      
    }
    
  }
 
  $user = $db->select()->from("user")->where("id=$userid")->find();

  if(!$user)
  {
    return json('用户不存在');
  }
  //开启事务
  $db->transaction("start transaction");

   $addcouponlist = $db->add("coupon",$data);
  if(!$addcouponlist)
  {
    $db->transaction("ROLLBACK");
    return json('添加优惠券失败');
  }
   $res=$db->delete("getcoupon","id=$couponid");
  if(!res)
  {
    $db->transaction("ROLLBACK");
    return json('删除优惠券失败');
  }
   if($addcouponlist&&$res)
   {
     //提交事务
     $db->transaction("commit");
     return json("领取成功",true);
   }else{
     return json("领取失败");
   }
}else if($action == "usecoupon")
{
    $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;
    $user = $db->select()->from("user")->where("id=$userid")->find();

    if(!$user)
    {
        return json('用户不存在');
    }

    $couponlist = $db->select()->from("coupon")->where("userid=$userid and state = '0'")->all();
    //var_dump($couponlist);
   
    //var_dump($data);die;
    if($couponlist)
    {
        return json("可用优惠券列表",true,$couponlist);
    }else{
        return json("查询失败");
    }

   
}else if($action=="unusecoupon")
{
    $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;
    $user = $db->select()->from("user")->where("id=$userid")->find();

    if(!$user)
    {
        return json('用户不存在');
    }

    $encouponlist = $db->select()->from("coupon")->where("userid=$userid and state != 0")->all();
    
    //var_dump($data);die;
    if($encouponlist)
    {
        return json("不可用优惠券列表",true,$encouponlist);
    }else{
        return json("查询失败");
    }
}else if($action=="updatecoupon")
{
    $couponid = isset($_POST['couponid']) ? $_POST['couponid'] : 0;

    $data=[
        "state"=>1
    ];
    $res=$db->update("coupon",$data,"id=$couponid");
    if($res)
    {
        return json("更新数据成功",true);
    }else{
        return json("更新数据失败");
    }
}
?>