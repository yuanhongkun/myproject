<?php
include_once("../config/init.php");

$action = isset($_GET['action']) ? $_GET['action'] : '';

if($action == "register")
{
  if($_POST)
  {
    //判断用户是否被注册过
    $username = isset($_POST['username']) ? $_POST['username'] : '';

    //查询用户数据
    $user = $db->select()->from("user")->where("username = '$username'")->find();

    if($user)
    {
      return json('该用户已被注册');
      
    }

    //生成密码盐
    $salt = $randstr->string();

    $password = md5($_POST['password'].$salt);
    
    //组装的数据
    $data = [
      "username"=>$username,
      "password"=>$password,
      "salt"=>$salt,
      "createtime"=>time()
    ];

    //插入
    if($db->add("user",$data))
    {
      return json('注册成功',true);
    }else{
      return json('注册失败');
    }
  }
}else if($action == "login")
{
  if($_POST)
  {
    
    //判断用户是否存在
    $username = isset($_POST['username']) ? $_POST['username'] : '';

    $user = $db->select()->from('user')->where("username = '$username'")->find();

    if(!$user)
    {
      return json('该用户不存在');
    }

    //验证密码
    $salt = $user['salt'];

    $password = md5($_POST['password'].$salt);

    if($password != $user['password'])
    {
      return json('密码错误');
    }else{
      //删除密码和密码盐
      unset($user['password']);
      unset($user['salt']);
    
      
      return json('登录成功',true,$user);
    }
  }
}else if($action == "avatar")
{
  $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;

  $user = $db->select()->from("user")->where("id=$userid")->find();

  if(!$user)
  {
    return json('用户不存在');
  }

    //修改个人头像
    if($_FILES['avatar']['size'] > 0 && upload("avatar","../assets/uploads"))
    {
      $upload = getResult();
      if(!$upload['result'])
      {
        return json($upload['msg']);
      }
  
      //上传成功
      $oldAvatar = $user['avatar'];
  
      $data = [
        "avatar"=>"assets/uploads/".$upload['data']
      ];
  
      //更新用户数据
      if($db->update("user",$data,"id = ".$user['id']))
      {
        //删除旧图片
        @is_file("../".$oldAvatar) && @unlink("../".$oldAvatar);
        $user['avatar'] = $data['avatar'];
        //重新更新cookie
        //删除密码和密码盐
        unset($user['password']);
        unset($user['salt']);
  
        return json('更新头像成功',true,$user);
      }else{
        return json('更新头像失败');
      }
  
    }else{
      return json('文件上传失败');
    }
}else if($action == "userinfo")
{
  $userid = isset($_POST['id']) ? $_POST['id'] : 0;

  $user = $db->select()->from("user")->where("id=$userid")->find();

  if(!$user)
  {
    return json('用户不存在');
  }

  $username = isset($_POST['username']) ? $_POST['username'] : '';

  $check = $db->select()->from("user")->where("id != $userid AND username = '$username'")->find();

  if($check)
  {
    return json('用户已存在');
  }

  $data = [
    'username'=>$username
  ];

  $password = isset($_POST['password']) ? $_POST['password'] : '';

  if(!empty($password))
  {
    $salt = $user['salt'];
    $repass = md5($password.$salt);
    $data['password'] = $repass;
  }

  if($db->update("user",$data,"id = $userid"))
  {
    unset($user['password']);
    unset($user['salt']);
    $user['username'] = $username;
    return json('更新成功',true,$user);
  }else{
    return json('更新失败');
  }
}else if($action == "selectaddress")
{
  $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;

  $user = $db->select()->from("user")->where("id=$userid")->find();

  if(!$user)
  {
    return json('用户不存在');
  }

  $user_addresslist = $db->select()->from("user_address")->where("userid=$userid")->all();
  //var_dump($user_addresslist);
  if($user_addresslist)
  {
    $user_address=array_column($user_addresslist,null);
    //var_dump($user_address);
    return json("查询成功",true,$user_address);
  }else{
    return json("查询失败");
  }
}


?>