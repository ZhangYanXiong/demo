<?php
/*连接数据库*/
	$link=mysqli_connect('localhost','root','');
	if(!$link){
		die("数据库连接失败！".mysql_error());
	}
	mysqli_select_db($link,'recruitment_web')or die("选择数据库失败!");
	mysqli_query($link,'set names utf8');
 ?>