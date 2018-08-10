<?php	
    error_reporting(E_ALL||E_NOTICE);
    // error_reporting(0);
	session_start();
	include '../conn.php';
	$user_id=$_POST['userid'];
	$user_password=$_POST['password'];
	$query="SELECT user_id ,user_password from login where user_id='".$user_id."' and user_password='".$user_password."'";
	$result=mysqli_query($link,$query)or die("查询失败!");
	$row=mysqli_fetch_array($result);
	if($result&&$row!=''){
		echo "登录成功！";
		echo "string".$row[user_id];
		echo "string".$row[user_password];
	}else{
		echo "登录失败,请重新登录！";
	}
?>