<?php
include_once("../config/init.php");

$action = isset($_GET['action']) ? $_GET['action'] : '';

if($action == "cartupdate")
{
    $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;
    $foodid = isset($_POST['foodid']) ? $_POST['foodid'] : '';
    $foodnum = isset($_POST['foodnum']) ? $_POST['foodnum'] : 0;

    $user = $db->select()->from("user")->where("id = $userid")->find();

    if(!$user)
    {
        return json('用户不存在');
    }

    $food = $db->select()->from('food')->where("id = '$foodid'")->find();

    if(!$food)
    {
      return json('该商品不存在');
    }

   //算价格
   $foodprice = (float)$foodnum*$food['price'];

   $data = [
       "foodid"=>$foodid,
       "userid"=>$userid,
       "foodnum"=>$foodnum,
       "foodprice"=>$foodprice
   ];

   //先判断购物车是否有商品数据
    $cart = $db->select()->from("cart")->where("userid=$userid and foodid=$foodid")->find();

    if($cart)
    {
        if($foodprice <=0)
        {
            //删除语句
            if($db->delete("cart","id=".$cart['id']))
            {
                return json('更新购物车失败',true);
            }
        }else{
            //更新语句
            if($db->update("cart",$data,"id=".$cart['id']))
            {
                return json('更新购物车成功',true);
            }
        }
    }else{
        //插入语句
        if($db->add("cart",$data))
        {
            return json('更新购物车成功',true);
        }
    }
}else if($action == "cartlist")
{
    //获取购物车数据
    $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;

    //获取订单id
    $orderid = isset($_POST['orderid']) ? $_POST['orderid'] : 0;

    //查询用户数据
    $user = $db->select()->from("user")->where("id = '$userid'")->find();

    if(!$user)
    {
      return json('该用户不存在');
    }
   
    
      $cartlist = $db->select("cart.*,food.name,food.cover,food.price")->from("cart")->join("food","cart.foodid=food.id")->where("cart.userid = $userid")->all();

    $addrdefault = $db->select()->from("user_address")->where("userid=$userid AND status =1 ")->find();

    $data = [
        "cartlist"=>$cartlist,
        "addrdefault"=>$addrdefault
    ];

    return json('购物车',true,$data);
    
    

}else if($action == "cartadd")
{
    //获取购物车数据
    $userid = isset($_POST['userid']) ? $_POST['userid'] : '';

    //查询用户数据
    $user = $db->select()->from("user")->where("id='$userid'")->find();

    if(!$user)
    {
        return json('该用户不存在');

    }

    $addrid = isset($_POST['addrid']) ? $_POST['addrid'] : 0;
    $address = $db->select()->from('user_address')->where("id=$addrid")->find();

    if(!$address)
  {
    return json('无收货地址');
  }

  $cartid = isset($_POST['cartid']) ? $_POST['cartid'] : '';
  $cartlist = $db->select()->from("cart")->where("id IN($cartid)")->all();

  $totalItem = 0;

  foreach($cartlist as $item)
  {
    $totalItem += $item['foodprice'];
  }

  //与用户余额比较
  $updateTotal = $user['money'] - $totalItem;

  if($updateTotal < 0)
  {
    return json('用户余额不足');
  }

  //开启事务 下单orde 订单产品order_food 更新余额user 删除购物车数据cart

  //开启事务
  $db->transaction("start transaction");

  //订单表
  $orderData = [
    "ordersn"=>$randstr->string(),
    "createtime"=>time(),
    "userid"=>$userid,
    "total"=>$totalItem,
    "addrid"=>$addrid,
    "status"=>1
  ];

  $orderid = $db->add("order",$orderData);

  if(!$orderid)
  {
      return json('订单插入失败');
  }

  $orderproData = [];

  foreach($cartlist as $item)
  {
      $value = [
          "orderid"=>$orderid,
          "foodid"=>$item['foodid'],
          "foodnum"=>$item['foodnum'],
          "foodprice"=>$item['foodprice']
      ];

      $orderproData[] = $value;
  }

  //插入订单产品
  $orderproRes = $db->addAll("order_food",$orderproData);

  if(!$orderproRes)
  {
      $db->transaction("ROLLBACK");
      return json("订单产品插入失败");
  }

  $userData = [
      'money'=>$updateTotal
  ];

  //更新用户余额
  $userRes = $db->update("user",$userData,"id = $userid");
  if(!$userRes)
  {
    $db->transaction("ROLLBACK");
    return json('更新用户余额失败');
  }

   //删除购物车数据
   $cartRes = $db->delete("cart","id IN($cartid)");

   if(!$cartRes)
   {
     $db->transaction("ROLLBACK");
     return json('更新购物车失败');
   }

   if($orderid && $orderproRes && $userRes && $cartRes)
   {
     //提交事务
     $db->transaction("commit");
     return json('下单成功',true);
   }else{
     $db->transaction("ROLLBACK");
     return json('下单失败');
   }
}else if($action == "cart")
{
  //获取购物车数据
  $userid = isset($_POST['userid']) ? $_POST['userid'] : '';

  //查询用户数据
  $user = $db->select()->from("user")->where("id='$userid'")->find();

  if(!$user)
  {
      return json('该用户不存在');

  }
  $foodid = isset($_POST['food']['id']) ? $_POST['food']['id'] : 0;
  $foodprice = isset($_POST['food']['price']) ? $_POST['food']['price'] : 0;
  //查询订单表是否已经存在该食品
  //var_dump($foodprice);
  $cart = $db->select()->from("cart")->where("foodid=$foodid and userid=$userid")->find();

  if($cart)
  {
    $data=[
      "foodnum"=>$cart['foodnum'] + 1,
      "foodprice"=>$cart['foodprice']+ $foodprice,
    ];
    //var_dump($data["foodprice"]);die;
    $cart=$db->update("cart",$data,"foodid=$foodid and userid=$userid");
    if(!$cart)
    {
      return json('更新购物车表失败');
    }else{
      return json('更新购物车成功',true,$cart);
    }
  }else{
    $data=[
      "foodid"=>$foodid,
      "foodnum"=>1,
      "foodprice"=>$foodprice,
      "userid"=>$userid
    ];
    $cart = $db->add("cart",$data);
    if($cart)
    {
      return json('添加购物车成功',true,$cart);
    }else{
      return json('添加购物车失败');
    }
  }
}

?>