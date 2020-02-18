<?php

class DB
{
	//链接数据库的属性 私有
	private $host;
	private $username;
	private $password;
	private $dbname;
	private $dbprefix = "pre_";
	private $link;
	private $sql = null;

	//构造函数指的意思是在实例化的时候立刻被自动调用的一个函数
	public function __construct($host ="localhost",$username="root",$password="root",$dbname=null)
	{
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->dbname = $dbname;

		$this->link = mysqli_connect($host,$username,$password) or die("链接失败");

		//选择数据库
		mysqli_select_db($this->link,$dbname);

		//设置编码
		mysqli_query($this->link,"SET NAMES UTF8");
	}

	//查询字段
	public function select($field = "*")
	{
		$this->sql = "SELECT $field ";
		return $this;
	}

	//表
	public function from($table = "",$alias='')
	{
		if(!empty($alias))
		{
			$this->sql .="FROM {$this->dbprefix}$table AS $alias ";
			return $this;
		}else{
			$this->sql .= "FROM {$this->dbprefix}$table AS $table ";
			return $this;
		}
		
	}

	//条件
	public function where($where = 1)
	{
		$this->sql .= "WHERE $where ";
		return $this;
	}

	//排序
	public function orderBy($field,$by="asc")
	{
		$this->sql .= "ORDER BY $field $by ";
		return $this;
	}

	public function orderByMuti($order)
	{
		$this->sql .= "ORDER BY $order ";
		return $this;
	}

	//限制条数
	public function limit($limit)
	{
		$this->sql .= "LIMIT $limit";
		return $this;
	}

	//链表
	//SELECT * FROM LEFT JOIN ON 
	public function join($table,$on,$by='LEFT')
	{
		$this->sql .= "$by JOIN {$this->dbprefix}$table AS $table ON $on ";
		return $this;
	}

	public function groupBy($field)
	{
		$this->sql .= "GROUP BY $field ";
		return $this;
	}

	//查询多条
	public function all()
	{
		$res = mysqli_query($this->link,$this->sql);

		if(!$res)
		{
			//当语句执行失败的效果
			$this->error();
			exit;
		}

		$data = [];

		while($row = mysqli_fetch_assoc($res))
		{
			$data[] = $row;
		}

		return $data;
	}

	//单条
	public function find()
	{
		$res = mysqli_query($this->link,$this->sql);

		if(!$res)
		{
			//当语句执行失败的效果
			$this->error();
			exit;
		}

		return mysqli_fetch_assoc($res);
	}


	//插入
	function add($table,$data)
	{
		$fields = array_keys($data);
		$index = "`".implode("`,`",$fields)."`";
		$value = "'".implode("','",$data)."'";
		$this->sql = "INSERT INTO {$this->dbprefix}$table ($index)VALUES($value)";

		$res = mysqli_query($this->link,$this->sql);

		if(!$res)
		{
			$this->error();
			return false;
		}

		//插入成功 
		return mysqli_insert_id($this->link);
	}

	//插入多条
	function addAll($table,$data)
	{
    $fields = array_keys($data[0]);
    $index = "`".implode("`,`",$fields)."`";
    $this->sql = "INSERT INTO {$this->dbprefix}$table ($index)VALUES";

    foreach($data as $item)
    {
      $value = "('".implode("','",$item)."')";
      $this->sql .= $value.",";
    }

    $this->sql = trim($this->sql,",");		

		$res = mysqli_query($this->link,$this->sql);

		if(!$res)
		{
			$this->error();
			return false;
		}

		//插入成功 
		return mysqli_insert_id($this->link);
	}

	public function update($table,$data,$where = 1)
	{
		$str = "";

		foreach($data as $key=>$item)
		{
			$str .= "`$key` = '$item',";
		}

		$str = trim($str,",");

		$this->sql = "UPDATE {$this->dbprefix}$table SET $str WHERE $where";

		$res = mysqli_query($this->link,$this->sql);

		if(!$res)
		{
			$this->error();
			exit;
		}

		//返回编辑成功后的影响行数
		return mysqli_affected_rows($this->link);
  }
	
  
  public function delete($table,$where)
  {
    $this->sql = "DELETE FROM {$this->dbprefix}$table WHERE $where";

    $res = mysqli_query($this->link,$this->sql);

    if(!$res)
    {
      $this->error();
      exit;
    }

    //返回影响行数
    return mysqli_affected_rows($this->link);
  }


	public function query($sql)
	{
		$this->sql = $sql;
		$res = mysqli_query($this->link,$this->sql);
		$res = mysqli_fetch_assoc($res);
		if(!$res)
		{
			$this->error();
			return false;
		}

		return $res;
	}

	//事务方法
	public function transaction($sql)
	{
		$this->sql = $sql;
		$res = mysqli_query($this->link,$this->sql);

		if(!$res)
		{
			$this->error();
			return false;
		}
		
		return $res;
	}
	//查看sql语句方法
	public function getSQL()
	{
		return $this->sql;
	}


	//数据库错误日志方法
	private function error()
	{
		$error = mysqli_error($this->link);
		//[2019-11-04 34:34:34] sql语句 (错误信息) \r\n
		$today = date("Y-m-d H:i");
		$content = "[$today] {$this->sql} ($error) \r\n";
		$path = str_replace("\\","/",dirname(__FILE__));
		file_put_contents("$path/mysql.log", $content,FILE_APPEND);
		echo "SQL语句执行失败，请查看错误日志";
		exit;
	}

}


?>