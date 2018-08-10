<?php
	session_start();
	include("conn.php");
	if($_SESSION['user']==""&&$_SESSION['pass']==""){
		echo "请登录,本网站";
		echo "<meat http-equiv=\"refresh\" content=\"3;url=register.html\">3秒钟转入主页，请稍等......";
	}