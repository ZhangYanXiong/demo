<?php
	error_reporting(0);
	session_start();
	include("conn.php");
	$id=$_POST['name'];
	$seat_status=$_POST['location'];
	$query="UPDATE numbering SET seat_status='1' where id='".$id."'";  
		$result=mysqli_query($link,$query) or die("失败1!");
		//$row=mysqli_affected_rows($link)or die("失败2!");
		if($result && mysqli_affected_rows($link)>0){
			echo "数据记录修改成功！"."</br>";
		}else{
			echo "修改记录失败，错误号：".mysql_error()."，错误原因：".mysql_error();
		}
?>