<?php
	error_reporting(0);  
	session_start();
	include("conn.php");
	$id=$_POST['id'];
	$seat_status=$_POST['seat_status'];
	$query="SELECT seat_status from numbering where id='".$id."' ";
	$result=mysqli_query($link,$query)or die("查询失败!");
	if($result==true){
		$myrow=mysqli_fetch_array($result);
		// print_r($myrow[seat_status]);
		if($myrow[seat_status]=='true'){
			$query="UPDATE numbering SET seat_status='false'where id='".$id."'";  
			$result=mysqli_query($link,$query) or die("1失败!");
			$row=mysqli_affected_rows($link)or die("2失败!");
			if($result&&$row>0){
				echo "数据记录修改成功！"."</br>";
			}else{
				echo "修改记录失败，错误号：".mysql_error()."，错误原因：".mysql_error()."</br>";
			}	
		}else{
			echo "对不起，此座位有人，请您重新选择";
		}
	}

?>