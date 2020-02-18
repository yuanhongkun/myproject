<?php
include_once("../config/init.php");

$action = isset($_GET['action']) ? $_GET['action'] : '';

if($action == "goodslist")
{
  
  $page = isset($_POST['page']) ? $_POST['page'] : 1;
  
  $limit = 5;
  $start = ($page-1)*$limit;
  //查询商品分类列表
  $goodslist = $db->select("food.*,foodcate.id as foodcateid,foodcate.name as catename")->from("food")->join("foodcate","food.cateid=foodcate.id")->orderby("id",'desc')->limit("$start,$limit")->all();

  //查询总数
  $num = $db->select("COUNT(id) as num")->from("food")->find();

  $data=["num"=>$num,"goodslist"=>$goodslist,"page"=>$page];
  
  if($data)
  {
      return json("商品分类列表",true,$data);

  }else{
      return json("商品分类列表失败");
  }
}else if($action=="foodinfo")
{
  $foodid = isset($_POST['foodid']) ? $_POST['foodid'] : 0;

  $food = $db->select()->from("food")->where("id=$foodid")->find();
  //查询食品分类
  $foodcate = $db->select()->from("foodcate")->all();
  $goods =[
    "food"=>$food,
    "foodcate"=>$foodcate
  ];
  if($goods)
  {
    return json("查询成功",true,$goods);
  }else{
    return json("该食品不存在");
  }
}else if($action=="foodcover")
{
  $foodid = isset($_POST['foodid']) ? $_POST['foodid'] : 0;

  $food = $db->select()->from("food")->where("id=$foodid")->find();

  if(!$food)
  {
    return json('食品不存在');
  }

  if($_FILES['cover']['size'] >0 && upload("cover","../assets/uploads"))
  {
    $upload = getResult();
    
    if(!$upload['result'])
    {
      return json($upload['msg']);
    }
    //上传成功
    $oldCover = $food['cover'];
    
    $data = [
      "cover"=>"assets/uploads/".$upload['data']
    ];
    
     //更新用户数据
     if($db->update("food",$data,"id = ".$food['id']))
     {
       //删除旧图片
       
       @is_file("../".$oldCover) && @unlink("../".$oldCover);
       $food['cover'] = $data['cover'];
       
       return json('更新图片成功',true,$food);
     }else{
       return json('更新图片失败');
     }
  }
}else if($action=="editfood")
{
  $name = isset($_POST['name']) ? $_POST['name'] : "";
  $price = isset($_POST['price']) ? $_POST['price'] : 0;
  $description = isset($_POST['description']) ? $_POST['description'] : "";
  $thumb = isset($_POST['thumb']) ? $_POST['thumb'] : "";
  $stock = isset($_POST['stock']) ? $_POST['stock'] : 0;
  $cateid = isset($_POST['cateid']) ? $_POST['cateid'] : 0;

  $foodid = isset($_POST['id']) ? $_POST['id'] : 0;

  $data = [
    "name"=>$name,
    "price"=>$price,
    "description"=>$description,
    "thumb"=>$thumb,
    "stock"=>$stock,
    "cateid"=>$cateid,
  ];
  //更新食品分类表
  $foodres = $db->update("food",$data,"id=$foodid");
  if($foodres)
  {
    return json("更新成功",true,$foodres);
  }else{
    return json("更新失败");
  }
}else if($action=="addfood")
{
  $name = isset($_POST['name']) ? $_POST['name'] : "";
  $price = isset($_POST['price']) ? $_POST['price'] : 0;
  $description = isset($_POST['description']) ? $_POST['description'] : "";
  $thumb = isset($_POST['thumb']) ? $_POST['thumb'] : "";
  $stock = isset($_POST['stock']) ? $_POST['stock'] : 0;
  $cateid = isset($_POST['cateid']) ? $_POST['cateid'] : 0;
  

  $food = $db->select()->from("food")->where("name='$name'")->find();
  if($food)
  {
    return json("该食品已存在");
  }
  $data = [
    "name"=>$name,
    "price"=>$price,
    "description"=>$description,
    "thumb"=>$thumb,
    "stock"=>$stock,
    "cateid"=>$cateid,
  ];
  //添加食品分类
  $addfood = $db->add("food",$data);
  if($addfood)
  {
    return json("添加成功",true);
  }else{
    return json("添加失败");
  }
}else if($action=="deletefood")
{
  $foodid = isset($_POST['foodid']) ? $_POST['foodid'] : "";

  //查询该食品是否存在
  $food = $db->select()->from("foodcate")->where("id=$foodid")->find();

  if(!$food)
  {
    return json("该食品不存在");
  }

  $deleteres = $db->delete("food","id=$foodid");

  if($deleteres)
  {
    return json("删除成功",true);
  }else{
    return json("删除失败");
  }
}


?>