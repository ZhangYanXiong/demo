<?php
	global $login;
	if($_POST['name']==""||$_POST[$pwd]==""){
		echo "登录失败";
		echo "请<a href=index.html>返回</a>";
		exit;
	}
	$login= array('name' =>$_POST['name'] ,'pwd'=>$_POST['pwd'] );
	session_start();
	session_register("login");
	if(session_is_registered('login')){
		echo "hello,".$login['name']."<br/>";
		echo "<a href=logout.php>退出登录</a><br/>";
	}else{
		echo "非法操作";
		exit;
	}
?>
