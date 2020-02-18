<?php
include_once("../config/init.php");

$action = isset($_GET['action']) ? $_GET['action'] : '';

if($action == "login")
{
  if($_POST)
  {
    
    //判断用户是否存在
    $name = isset($_POST['name']) ? $_POST['name'] : '';

    $admin = $db->select()->from('admin')->where("name = '$name'")->find();

    // if(!$admin)
    // {
    //   return json('该管理员不存在');
    // }

    //验证密码
    $salt = $admin['salt'];

    $password = md5($_POST['password'].$salt);
      
    if($password != $admin['password'])
    {
      return json('密码错误');
    }else{
      //删除密码和密码盐
      unset($admin['password']);
      unset($admin['salt']);
    
      
      return json('登录成功',true,$admin);
    }
  }
}else if($action=="adminlist")
{
  //查询所有管理员列表
  $admin = $db->select()->from("admin")->all();
  if($admin)
  {
    return json("查询列表成功",true,$admin);
  }else{
    return json("查询失败");
  }
}else if($action == "addadmin")
{
  $name = isset($_POST['name']) ? $_POST['name'] : "";
  //查询管理员用户是否存在
  $admin = $db->select()->from("admin")->where("name='$name'")->find();

  if($admin)
  {
    return json("该管理员账号已存在");
  }
  $password = isset($_POST['password']) ? $_POST['password'] : "";

  //生成密码盐
  $salt = $randstr->string();

  $password = md5($password.$salt);
  //添加管理员
  $data=[
    "name"=>$name,
    "password"=>$password,
    "salt"=>$salt,
    "createdtime"=>time()
  ];

  $addres = $db->add("admin",$data);

  if($addres)
  {
    return json("添加管理员成功",true);
  }else{
    return json("添加失败");
  }
}else if($action == "admininfo")
{
  $adminid = isset($_POST['adminid']) ? $_POST['adminid'] : 0;
  //查询管理员
  $admin = $db->select()->from("admin")->where("id=$adminid")->find();

  if(!$admin)
  {
    return json("该管理员不存在");
  }else{
    return json("查询成功",true,$admin);
  }

}else if($action=="editadmin")
{
  $name = isset($_POST['name']) ? $_POST['name'] : "";
  $password = isset($_POST['password']) ? $_POST['password'] : "";

  $adminid = isset($_POST['adminid']) ? $_POST['adminid'] : "";

  //查询管理员用户是否存在
  $admin = $db->select()->from("admin")->where("name='$name'")->find();

  if($admin)
  {
    return json("该管理员账号已存在");
  }
  //生成密码盐
  $salt = $randstr->string();

  $password = md5($password.$salt);
  //编辑管理员
  $data=[
    "name"=>$name,
    "password"=>$password,
    "salt"=>$salt,
    "createdtime"=>time()
  ];

  $editres = $db->update("admin",$data,"id=$adminid");

  if($editres)
  {
    return json("编辑成功",true,$editres);
  }else{
    return json("编辑失败");
  }
}else if($action == "deleteadmin")
{
  $adminid = isset($_POST['adminid']) ? $_POST['adminid'] : "";

  //查询管理员用户是否存在
  $admin = $db->select()->from("admin")->where("id=$adminid")->find();

  if(!$admin)
  {
    return json("管理员不存在");
  }

  $deleteres = $db->delete("admin","id=$adminid");

  if($deleteres)
  {
    return json("删除成功",true);
  }else{
    return json("删除失败");
  }
}


?>