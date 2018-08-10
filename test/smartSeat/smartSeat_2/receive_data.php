<?php
	error_reporting(0);  
	session_start();
	include("conn.php");
	$id=$_POST['id'];
	// echo "hdsah:".$id[0];
	$seat_status=$_POST['seat_status'];
	echo $seat_status[0];
	for($i=0;$i<count($seat_status);$i++){
		$query="UPDATE numbering SET seat_status='".$seat_status[$i]."' where id='".$id[$i]."'";  
		$result=mysqli_query($link,$query) or die("1失败!");
		$row=mysqli_affected_rows($link)or die("2失败!");
		if($result&&$row>0){
			echo "数据记录修改成功！"."</br>";
		}else{
			echo "修改记录失败，错误号：".mysql_error()."，错误原因：".mysql_error()."</br>";
		}	
	}

?>