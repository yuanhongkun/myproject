<?php
include_once("../config/init.php");

$action = isset($_GET['action']) ? $_GET['action'] : '';

if($action == "homefood")
{
  //查询置顶食品
  $topcate = $db->select()->from("foodcate")->where("name IN('水果特惠','每日必抢','嗨吃福利','鲜蜂力荐')")->all();

  //先查询分类
  $catelist = $db->select()->from("foodcate")->all();

    foreach($catelist as $key=>$item)
    {
      $foodlist = $db->select()->from("food")->where("cateid = ".$item['id'])->limit("6")->all();
      $catelist[$key]['foodlist'] = $foodlist;
    }

    $data = [
      "topcate"=>$topcate,
      "catelist"=>$catelist,
    ];
    return json("读取失败",true,$data);
    
}else if($action == 'catelist')
{
  $catelist = $db->select()->from("foodcate")->all();
  return json('分类',true,$catelist);

}else if($action == "foodlist")
{
  $page = isset($_POST['page']) ? $_POST['page'] : 1;
  $cateid = isset($_POST['cateid']) ? $_POST['cateid'] : 0;

  $where = 1;
  if($cateid)
  {
    $where = "cateid=$cateid";
  }

  //偏移量
  $limit = 16;
  $start = ($page-1)*$limit;

  $foodlist = $db->select()->from("food")->where($where)->limit("$start,$limit")->all();

  if($foodlist)
  {
    return json('商品列表',true,$foodlist);
    
  }else{
    return json('商品列表',false,[]);
  }
}else if($action == "fooddetail")
{
  $foodid = isset($_POST['id']) ? $_POST['id'] : 0;
  
  $food =$db->select("food.*,foodcate.id,foodcate.typeid,foodcate.name as catename,foodtype.id,foodattr.name as attrname,foodattr.typeid,foodattr.value")->from("food")->join("foodcate","food.cateid=foodcate.id")->join("foodtype","foodcate.typeid=foodtype.id")->join("foodattr","foodtype.id=foodattr.typeid")->where("food.id=$foodid")->find();

  if($food)
  {
    return json("食品列表获取成功",true,$food);
  }else{
    return json ("食品获取失败",false,[]);
  }
}else if($action == "searchfood")
{
  $keywords = isset($_POST['keywords']) ? $_POST['keywords'] : '';

  //查询置顶食品
  $topcate = $db->select()->from("foodcate")->where("name IN('水果特惠','每日必抢','嗨吃福利','鲜蜂力荐')")->all();

  //先查询分类
  $catelist = $db->select("foodcate.*,food.name,food.cateid")->from("foodcate")->join("food","foodcate.id=food.cateid")->where("food.name LIKE '%$keywords%'")->all();

  
    foreach($catelist as $key=>$item)
    {
      $foodlist = $db->select()->from("food")->where("cateid = ".$item['id']." and name LIKE '%$keywords%'")->limit("6")->all();
      $catelist[$key]['foodlist'] = $foodlist;
    }

    $data = [
      "topcate"=>$topcate,
      "catelist"=>$catelist,
    ];
    return json("读取失败",true,$data);

}else if($action=="foodcateinfo")
{
  $topcateid = isset($_POST['topcateid']) ? $_POST['topcateid'] : 0;

  $foodcate = $db->select()->from("foodcate")->where("id=$topcateid")->find();

  if($foodcate)
  {
    return json("食品分类",true,$foodcate);
  }else{
    return json("查询失败");
  }
}else if($action == "topcatefood")
{
  $topcateid = isset($_POST['topcateid']) ? $_POST['topcateid'] : 0;

  $foodlist = $db->select()->from("food")->where("cateid=$topcateid")->all();

  if($foodlist)
  {
    return json("食品",true,$foodlist);
  }else{
    return json("查询失败");
  }
}


?>