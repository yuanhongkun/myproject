<?php
include_once("../config/init.php");

$action = isset($_GET['action']) ? $_GET['action'] : '';

if($action == "goodscatelist")
{
  
  $page = isset($_POST['page']) ? $_POST['page'] : 1;
  
  $limit = 5;
  $start = ($page-1)*$limit;
  //查询商品分类列表
  $goodscatelist = $db->select("foodcate.*,foodtype.id as foodtypeid,foodtype.name as typename")->from("foodcate")->join("foodtype","foodcate.typeid=foodtype.id")->orderby("id",'desc')->limit("$start,$limit")->all();

  //查询总数
  $num = $db->select("COUNT(id) as num")->from("foodcate")->find();

  $data=["num"=>$num,"goodscate"=>$goodscatelist,"page"=>$page];
  
  if($data)
  {
      return json("商品分类列表",true,$data);

  }else{
      return json("商品分类列表失败");
  }
}else if($action=="goodscateinfo")
{
  $goodscateid = isset($_POST['goodscateid']) ? $_POST['goodscateid'] : 0;

  $goodscate = $db->select()->from("foodcate")->where("id=$goodscateid")->find();
  //查询食品分类类型
  $foodtype = $db->select()->from("foodtype")->all();
  $goods =[
    "goodscate"=>$goodscate,
    "foodtype"=>$foodtype
  ];
  if($goods)
  {
    return json("查询成功",true,$goods);
  }else{
    return json("该分类不存在");
  }
}else if($action=="cover")
{
  $goodscateid = isset($_POST['goodscateid']) ? $_POST['goodscateid'] : 0;

  $goodscate = $db->select()->from("foodcate")->where("id=$goodscateid")->find();

  if(!$goodscate)
  {
    return json('食品不存在');
  }

  if($_FILES['cover']['size']>0 && upload("cover","../assets/uploads"))
  {
    $upload = getResult();
    if(!$upload['result'])
    {
      return json($upload['msg']);
    }
    //上传成功
    $oldCover = $goodscate['cover'];
  
    $data = [
      "cover"=>"assets/uploads/".$upload['data']
    ];

     //更新用户数据
     if($db->update("foodcate",$data,"id = ".$goodscate['id']))
     {
       //删除旧图片
       @is_file("../".$oldCover) && @unlink("../".$oldCover);
       $goodscate['cover'] = $data['cover'];
       return json('更新图片成功',true,$goodscate);
     }else{
       return json('更新图片失败');
     }
  }
}else if($action=="editgoodscate")
{
  $name = isset($_POST['name']) ? $_POST['name'] : "";
  $typeid = isset($_POST['typeid']) ? $_POST['typeid'] : 0;

  $foodcateid = isset($_POST['id']) ? $_POST['id'] : "";

  $data = [
    "name"=>$name,
    "typeid"=>$typeid,
  ];
  //更新食品分类表
  $foodcateres = $db->update("foodcate",$data,"id=$foodcateid");
  if($foodcateres)
  {
    return json("更新成功",true,$foodcateres);
  }else{
    return json("更新失败");
  }
}else if($action=="addgoodscate")
{
  $name = isset($_POST['name']) ? $_POST['name'] : "";
  $typeid = isset($_POST['typeid']) ? $_POST['typeid'] : 0;

  $foodcate = $db->select()->from("foodcate")->where("name='$name'")->find();
  if($foodcate)
  {
    return json("该分类已存在");
  }
  $data = [
    "name"=>$name,
    "typeid"=>$typeid,
  ];
  //添加食品分类
  $addfoodcate = $db->add("foodcate",$data);
  if($addfoodcate)
  {
    return json("添加成功",true);
  }else{
    return json("添加失败");
  }
}else if($action=="deletegoodscate")
{
  $goodscateid = isset($_POST['goodscateid']) ? $_POST['goodscateid'] : "";

  //查询该分类是否存在
  $goodscate = $db->select()->from("foodcate")->where("id=$goodscateid")->find();

  if(!$goodscate)
  {
    return json("该食品不存在");
  }

  $deleteres = $db->delete("foodcate","id=$goodscateid");

  if($deleteres)
  {
    return json("删除成功",true);
  }else{
    return json("删除失败");
  }
}


?>