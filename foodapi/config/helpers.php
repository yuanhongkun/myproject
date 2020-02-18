<?php


function json($msg=null,$result=false,$data=null)
{
  $json = [
    'msg'=>$msg,
    'result'=>$result,
    'data'=>$data,
  ];

  echo json_encode($json);
}



function conf($name)
{
  global $db;
  //获取系统配置信息
  $cookieConf = isset($_COOKIE['config']) ? $_COOKIE['config'] : "";

  if(empty($cookieConf))
  {
    $config = $db->select()->from("config")->all();
    setcookie("config",json_encode($config));
    $cookieConf = $config;
  }else{
    $cookieConf = json_decode($cookieConf,true); //将json转化为php的数组
  }

  foreach($cookieConf as $item)
  {
    if($item['name'] == $name)
    {
      return $item['value'];
    }
  }

  return false;

}


//提示跳转
function showAdmin($msg='',$url='')
{
  $host = $_SERVER['HTTP_HOST'];
  $redirect = "http://".$host;
  @header("Location:$redirect/admin/404.php?msg=$msg&url=$url");
  exit;
}



//提示跳转
function showMsg($msg='',$url='')
{
  $host = $_SERVER['HTTP_HOST'];
  $redirect = "http://".$host;
	@header("Location:$redirect/404.php?msg=$msg&url=$url");
	exit;
}


//发送邮件
function sendMail($email,$subject,$body)
{

  //判断邮箱是否为空
  if(empty($email))
  {
    return false;
  }

  if(empty($subject))
  {
    return false;
  }

  if(empty($body))
  {
    return false;
  }

  include_once('phpmail/class.phpmailer.php');

  try 
  {
    //初始化一个邮件发送的对象
    $mail = new PHPMailer(true);

    $mail->IsSMTP(); //使用smtp邮件发送协议
    $mail->SMTPAuth   = true;
    $mail->Port       = 25;
    $mail->Host       = "smtp.163.com";  //第三方地址
    $mail->Username   = "dancefunk@163.com"; //服务账号  
    $mail->Password   = "h1901123";  //密码

    //"邮件回复人地址","邮件回复人名称
    $mail->AddReplyTo("dancefunk@163.com","Flyes社区");

    $mail->From       = "dancefunk@163.com"; //发件人地址
    $mail->FromName   = "Flyes社区";        //发件人名称

    $mail->AddAddress($email); //收件人地址

    $mail->Subject  = $subject;   //邮件主题

    $mail->WordWrap   = 80; // 80个字符换行

    $mail->MsgHTML($body);    //发送内容

    $mail->IsHTML(true); //是否可以发送html

    $mail->Send();
    return true;
  } catch (phpmailerException $e) {
      // echo $e->errorMessage();
      return false;
  }
}










//得到当前网址
function get_url(){
	$str = $_SERVER['PHP_SELF'].'?';
	if($_GET){
		foreach ($_GET as $k=>$v){  //$_GET['page']
			if($k!='page'){
				$str .= $k.'='.$v.'&';
			}
		}
	}
	return $str;
}



//分页函数
/**
 *@pargam $current	当前页
 *@pargam $count	记录总数
 *@pargam $limit	每页显示多少条
 *@pargam $size		中间显示多少条
 *@pargam $class	样式
*/
function page($current,$count,$limit,$size,$class='sabrosus'){
	$str='';
	if($count>$limit){
		$pages = ceil($count/$limit);//算出总页数
		$url = get_url();//获取当前页面的URL地址（包含参数）
		
		$str.='<div class="'.$class.'">';
		//开始
		if($current==1){
			$str.='<span class="disabled">首&nbsp;&nbsp;页</span>';
			$str.='<span class="disabled">  &lt;上一页 </span>';
		}else{
			$str.='<a href="'.$url.'page=1">首&nbsp;&nbsp;页 </a>';
			$str.='<a href="'.$url.'page='.($current-1).'">  &lt;上一页 </a>';
		}
		//中间
		//判断得出star与end
	    
		 if($current<=floor($size/2)){ //情况1
			$star=1;
			$end=$pages >$size ? $size : $pages; //看看他两谁小，取谁的
		 }else if($current>=$pages - floor($size/2)){ // 情况2
				 
			$star=$pages-$size+1<=0?1:$pages-$size+1; //避免出现负数
		
			$end=$pages;
		 }else{ //情况3
		 
			$d=floor($size/2);
			$star=$current-$d;
			$end=$current+$d;
		 }
	
		for($i=$star;$i<=$end;$i++){
			if($i==$current){
				$str.='<span class="current">'.$i.'</span>';	
			}else{
				$str.='<a href="'.$url.'page='.$i.'">'.$i.'</a>';
			}
		}
		//最后
		if($pages==$current){
			$str .='<span class="disabled">  下一页&gt; </span>';
			$str.='<span class="disabled">尾&nbsp;&nbsp;页  </span>';
		}else{
			$str.='<a href="'.$url.'page='.($current+1).'">下一页&gt; </a>';
			$str.='<a href="'.$url.'page='.$pages.'">尾&nbsp;&nbsp;页 </a>';
		}
		$str.='</div>';
	}
	
	return $str;
}



//封装上传文件
//返回的结果
$result = array("result"=>false,"msg"=>"","data"=>null);
function upload($name,$path,$size=123123123,$ext=array('png','jpeg','gif','jpg'))
{
  global $result;
  $file = $_FILES[$name];
  $error = $file['error'];

  //判断上传错误
  if($error > 0)
  {
    switch($error)
    {
      case 1:
        $result['msg'] = "上传的文件超过了php.ini配置大小";
        break;
      case 2:
        $result['msg'] = '超过表单隐藏域限制的大小配置';
        break;
      case 3:
        $result['msg'] = '文件上传到一半网络中断';
        break;
      case 4:
        $result['msg'] = '无文件上传';
        break;
      default:
        $result['msg'] = '未知错误';
    }

    return false;
  }

  //判断上传的文件大小是否有超过自己限制的
  if($file['size'] > $size)
  {
    $result['msg'] = "超过函数限制上传大小";
    return false;
  }

  //类型
  $type = PATHINFO($file['name'],PATHINFO_EXTENSION);

  //判断是否是允许的上传类型
  if(!in_array($type,$ext))
  {
    $result['msg'] = '该文件不是允许上传的类型';
    return false;
  }

  //重新命名文件
  //mt_rand() 从一个范围内随机选择数字
  $filname = date("YmdHis").mt_rand(111111,9999999).".".$type;

  if(!is_dir($path))
  {
    $result['msg'] = '上传路径有误，请重新填写';
    return false;
  }

  //判断文件是否是通过http post上传的
  if(is_uploaded_file($file['tmp_name']))
  {
    //将临时文件移动 到我指定的目录 $path
    $res = move_uploaded_file($file['tmp_name'],$path."/".$filname);

    if($res)
    {
      //成功
      $result['result'] = true;
      $result['msg'] = '上传文件成功';
      $result['data'] = $filname;
      return true;
    }else{
      //失败
      $result['msg'] = '上传文件失败';
      return false;
    }
  }else{
    $result['msg'] = '非法上传';
    return false;
  }
}

//多张
function uploads($name,$path,$size = 1231234211,$ext=array('png','jpeg','gif','jpg'))
{
  global $result;
  $file = $_FILES[$name];

  foreach($file['name'] as $key=>$item)
  {
    $error = $file['error'][$key];

    //判断上传错误
    if($error>0)
    {
      continue;
    }
    //判断上传的文件大小是否有超过自己限制的
    if($file['size'][$key] > $size)
    {
      continue;
    }
    //类型
    $type = PATHINFO($file['name'][$key],PATHINFO_EXTENSION);

    //判断是否是允许的上传类型
    if(!in_array($type,$ext))
    {
      continue;
    }
    //重新命名文件
    //mt_rand() 从一个范围内随机选择数字
    $filname = date("YmdHis").mt_rand(111111,9999999).".".$type;

    if(!is_dir($path))
    {
      $result['msg'] = '上传路径有误，请重新填写';
      return false;
    }

    //判断文件是否是通过http post上传的
    if(is_uploaded_file($file['tmp_name'][$key]))
    {
      //将临时文件移动 到我指定的目录 $path
      $res = move_uploaded_file($file['tmp_name'][$key],$path."/".$filname);

      if($res)
      {
        //成功
        $result['result'] = true;
        $result['msg'] = '上传文件成功';
        if(is_array($result['data']))
        {
          $result['data'][] = 'assets/uploads/'.$filname;
        }else{
          $result['data'] = [];
          $result['data'][] = 'assets/uploads/'.$filname;
        }
      }else{
        //失败
        continue;
      }
    }else{
      continue;
    }
  }
}

//获取文件上传的结果
function getResult()
{
  global $result;
  return $result;
}



/**
 * 获取子孙树
 * @param   array        $data   待分类的数据
 * @param   int/string   $id     要找的子节点id
 * @param   int          $lev    节点等级
 */
function getSubTree($data,$pid=0,$lev=0)
{
  static $son = array();
  foreach($data as $key=>$item)
  {
    if($item['parentid'] == $pid)
    {
      $item['lev'] = $lev;  //给数组添加一个新的属性 用来表示楼层
      $son[] = $item;  //追加进去变成二维数组
      getSubTree($data,$item['id'],$lev+1);
    }
  }

  return $son;
}


function showTree($level,$str="▬")
{
  $result = "";
  for($i=0;$i<$level;$i++)
  {
    $result .= $str;
  }

  return $result;
}


?>