<?php
	include("conn.php");
	$query="UPDATE numbering SET seat_status='false'where id='1'";  
	$result=mysqli_query($link,$query);
	$row=mysqli_affected_rows($link);
	if($result && $row>0){
		echo "数据记录修改成功！"."</br>";
	}else{
		echo "修改记录失败，错误号：".mysql_error()."，错误原因：".mysql_error()."</br>";
	}	

	$query="UPDATE numbering SET seat_status='true'where id='".$id."'";  
			$result=mysqli_query($link,$query);
			$row=mysqli_affected_rows($link);
			if($result&&$row>0){
				echo "数据记录修改成功！"."</br>";
			}else{
			echo "修改记录失败，错误号：".mysql_error()."，错误原因：".mysql_error()."</br>";
			}	
?>