<?php
include_once("../config/init.php");

$action = isset($_GET['action']) ? $_GET['action'] : '';

if($action == "orderlist")
{
  //获取购物车数据
  $userid = isset($_POST['userid']) ? $_POST['userid'] : '';
  $status = isset($_POST['status']) ? $_POST['status'] : 0;
  $page = isset($_POST['page']) ? $_POST['page'] : 1;

  //查询用户数据
  $user = $db->select()->from("user")->where("id = '$userid'")->find();

  if(!$user)
  {
    return json('该用户不存在');
  }

  $where = "userid = $userid";

  if($status)
  {
    $where .= " AND status = $status";
  }

  $limit = 10;
  $start = ($page-1)*$limit;

  $orderlist = $db->select()->from("order","userorder")->where($where)->orderby("id",'desc')->limit("$start,$limit")->all();

  //查询订单商品
  foreach($orderlist as $key=>$item)
  {
    $ordepro = $db->select("order_food.*,food.name,food.cover")->from("order_food")->join("food","order_food.foodid = food.id")->where("order_food.orderid = ".$item['id'])->all();

    $ordernum = $db->select("sum(foodnum) AS ordernum")->from("order_food")->where("orderid = ".$item['id'])->find();

    $orderlist[$key]['orderpro'] = $ordepro;
    $orderlist[$key]['ordernum'] = $ordernum['ordernum'];
  }

  if($orderlist)
  {
    return json('订单列表',true,$orderlist);
  }else{
    return json('无订单数据');
  }

  
}else if($action == "orderinfo")
{
  $orderid = isset($_POST['orderid']) ? $_POST['orderid'] : 0;

  // $order = $db->select("userorder.*,user_address.info,user_address.consignee,user_address.mobile")->from("order","userorder")->join("user_address","userorder.addrid = user_address.id")->where("userorder.id = $orderid")->find();

  $sql = "SELECT userorder.*,userorder.id AS orderid,userorder.status AS orderStatus,address.*,province.region_name AS provinceName,city.region_name AS cityName,district.region_name AS districtName FROM pre_order AS userorder LEFT JOIN pre_user_address AS address ON userorder.addrid = address.id LEFT JOIN pre_region AS province ON address.province = province.region_id LEFT JOIN pre_region AS city ON address.city = city.region_id LEFT JOIN pre_region AS district ON address.district = district.region_id WHERE userorder.id = $orderid";

  $order = $db->query($sql);

  if(!$order)
  {
    return json('无订单数据');
  }

  //订单商品
  $ordepro = $db->select("order_food.*,food.name,food.cover")->from("order_food")->join("food","order_food.foodid = food.id")->where("order_food.orderid = ".$order['orderid'])->all();

  $ordernum = $db->select("sum(foodnum) AS ordernum")->from("order_food")->where("orderid = ".$order['orderid'])->find();

  $order['orderpro'] = $ordepro;
  $order['ordernum'] = $ordernum['ordernum'];

  return json('订单详情',true,$order);
}else if($action == "confirmOrder")
{
  $orderid = isset($_POST['orderid']) ? $_POST['orderid'] : 0;

  $order = $db->select()->from("order",'userorder')->where("id = $orderid")->find();

  if(!$order)
  {
    return json('订单不存在');
  }

  $data = [
    'status'=>3
  ];

  if($db->update("order",$data,"id = $orderid"))
  {
    return json('确认收货成功',true);
  }else{
    return json('确认收货失败');
  }
}else if($action == "commentAdd")
{
  if($_POST)
  {
    $orderid = isset($_POST['orderid']) ? $_POST['orderid'] : 0;

    //查询订单数据
    $order = $db->select()->from("order","userorder")->where("id=$orderid AND status = 3 ")->find();

    if(!$order)
    {
      return json ('订单数据不存在');
    }

    $commentData = [
      "orderid"=>$orderid,
      "isshow"=>$_POST['isshow'],
      "content"=>$_POST['content'],
      "rate"=>$_POST['rate'],
      "createtime"=>time()
    ];

    //是否有文件上传
    if(isset($_FILES['thumb']) && is_array($_FILES['thumb']['size']))
    {
      uploads("thumb","../assets/uploads");
      $upload = getResult();
      if($upload['result'])
      {
        $commentData['thumb'] = implode(",",$upload['data']);
      }
    }
    //开启事务
    $db->transaction("start transaction");

    //插入评论表
    $commentRes = $db->add("comment",$commentData);

    if(!$commentRes)
    {
      return json('评论添加失败');
    }

    //修改订单状态
    $orderData = [
      "status"=>4
    ];

    $orderRes = $db->update("order",$orderData,"id = $orderid");

    if(!$orderRes)
    {
      $db->transaction("ROLLBACK");
      return json('订单状态修改失败');
    }

    if($commentRes && $orderRes)
    {
      //提交事务
      $db->transaction("commit");
      return json('感谢您的评价',true);
    }else{
      $db->transaction("ROLLBACK");
      return json('评价失败');
    }
  }
}else if($action =="addorder")
{
  $foodid = isset($_POST['foodid']) ? $_POST['foodid'] : 0;
  $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;
  $food = $db->select()->from("food")->where("id=$foodid")->find();
  if(!$food)
  {
    return json("该食品不存在");
  }

  $user = $db->select()->from("user")->where("id=$userid")->find();
  if(!$user)
  {
    return json("该顾客不存在");
  }

  //添加购物车
  $data=[
    "foodid"=>$foodid,
    "foodnum"=>1,
    "foodprice"=>$food['price'],
    "userid"=>$userid
  ];
  $cart = $db->add("cart",$data);
  if($cart)
  {
    return json('添加成功',true,$cart);
  }else{
    return json("添加失败");
  }
}

?>