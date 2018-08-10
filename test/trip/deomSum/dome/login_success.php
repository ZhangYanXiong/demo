<?php

	session_start();
	$user=$POST['user'];//获取表单提交过来的用户名
	$pass=$_POST['pass'];//获取表单提交过来的密码
	if($user!="" && $pass!=""){
		echo "登录成功！";
		$_SESSION['user']=$user;
		echo "<meat http-equiv=\"refresh\" content=\"3;url=conn.php\">3秒钟转入主页，请稍等......";
	}else{
		echo "<script>alert('登录失败ee！');history.back();</script>";
	}
?>