<?php 
include_once("../config/init.php");

$action = isset($_GET['action']) ? $_GET['action'] : '';
if($action=="province")
{
  $province = $db->select()->from("region")->where("parent_id = 1")->all();

  return json("省",true,$province);
}else if($action == "city")
{
  $regionid = isset($_POST['regionid']) ? $_POST['regionid'] : 0;

  $city = $db->select()->from("region")->where("parent_id = $regionid")->all();

  return json('市',true,$city);
}else if($action=="district")
{
  $regionid = isset($_POST['regionid']) ? $_POST['regionid'] : 0;

  $district = $db->select()->from("region")->where("parent_id = $regionid")->all();

  return json('地区',true,$district);
}
elseif($action=="addresslist")
{
    $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;

    $user = $db->select()->from("user")->where("id = $userid")->find();
  //var_dump($user);
    if(!$user)
    {
      return json('用户不存在');
    }
  
    $addresslist = $db->select()->from("user_address")->where("userid = $userid")->all();
  //var_dump($addresslist);die;
    return json('查询用户收货地址',true,$addresslist);
  
}else if($action == "addressdefault")
{
  $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;
  $addrid = isset($_POST['addrid']) ? $_POST['addrid'] : 0;

  $user = $db->select()->from("user")->where("id = $userid")->find();

  if(!$user)
  {
    return json('用户不存在');
  }

  //启动事务
  $db->update("user_address",['status'=>0],"userid = $userid");

  if($db->update("user_address",['status'=>1],"id = $addrid"))
  {
    return json('更新默认地址成功',true);
  }else{
    return json('更新默认地址失败');
  }
}else if($action == "addressadd")
{
  if($_POST)
  {
    $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;

    $user = $db->select()->from("user")->where("id = $userid")->find();

    if(!$user)
    {
      return json('用户不存在');
    }

    $data = [
      "userid"=>$userid,
      "consignee"=>$_POST['consignee'],
      "province"=>$_POST['province'],
      "city"=>$_POST['city'],
      "district"=>$_POST['district'],
      "info"=>$_POST['info'],
      "mobile"=>$_POST['mobile'],
      "status"=>0
    ];

    if($db->add("user_address",$data))
    {
      return json('添加收货地址成功',true);
    }else{
      return json('添加收货地址失败');
    }
  }
}else if($action == "addressdel")
{
  $addrid = isset($_POST['addrid']) ? $_POST['addrid'] : 0;

  if($db->delete("user_address","id = $addrid"))
  {
    return json('删除成功',true);
  }else{
    return json('删除失败');
  }
}else if($action == "addressinfo")
{
  $addrid = isset($_POST['addrid']) ? $_POST['addrid'] : 0;

  $sql = "SELECT address.*,province.region_name AS provinceName,city.region_name AS cityName,district.region_name AS districtName
   FROM pre_user_address AS address LEFT JOIN pre_region AS province ON address.province = province.region_id  LEFT JOIN pre_region
    AS city ON address.city = city.region_id  LEFT JOIN pre_region AS district ON address.district = district.region_id WHERE address.id = $addrid";

  $address = $db->query($sql);
//var_dump($address);die;
  //查出所在省的市
  $city = $db->select()->from("region")->where("parent_id = ".$address['province'])->all();

  //区域
  $district = $db->select()->from('region')->where("parent_id = ".$address['city'])->all();

  $province = $db->select()->from("region")->where("parent_id = 1")->all();

  $data = [
    "address"=>$address,
    "city"=>$city,
    "province"=>$province,
    "district"=>$district,
  ];

  return json('返回收货地址',true,$data);
}else if($action == "addressedit")
{
  $addrid = isset($_POST['id']) ? $_POST['id'] : 0;

  $addr = $db->select()->from("user_address")->where("id = $addrid")->find();

  if(!$addr)
  {
    return json('未发现收货地址');
  }

  $data = [
    "consignee"=>$_POST['consignee'],
    "province"=>$_POST['province'],
    "city"=>$_POST['city'],
    "district"=>$_POST['district'],
    "info"=>$_POST['info'],
    "mobile"=>$_POST['mobile'],
  ];

  if($db->update("user_address",$data,"id = $addrid"))
  {
    return json('更新收货地址成功',true);
  }else{
    return json('更新收货地址失败');
  }
}
?>
