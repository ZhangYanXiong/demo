<?php
/*连接数据库*/
	$link=mysqli_connect('localhost','root','');
	if(!$link){
		die("数据库连接失败！".mysql_error());
	}else{
		echo "连接成功！"."</br>";
	}
	mysqli_select_db($link,'smart_seat')or die("失败!");
	mysqli_query($link,'set names utf8');
 ?>