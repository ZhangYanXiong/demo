<?php
	//连接数据库
	$link=mysqli_connect("localhost","root","")or die("数据库连接成功!");
	//选择数据库
	mysql_select_db($link,"trip") or die("数据库不存在!");

	//获取表单提交过来的数据
	$phone=$_POST['phone']|null;
	$country=$_POST['ctry'];
	$password=$_POST['pwd'];
	$verfcode=$_POST['vercode'];
	$vcode=$_POST['code'];
	$check=$_POST['checkm'];
	//添加数据的SQL语句
	$exec="insert into trip values($phone,'$country','$password','$verfcode','$vcode','check')";
	//执行添加操作，返回受影响的行数
	$result=mysql_query($ecec);
	if($result){
		echo "注册成功";
		//关闭数据库
		mysql_close();
	}

?>
