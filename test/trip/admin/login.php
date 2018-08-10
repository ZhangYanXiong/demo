<?php
	/*后台管理员登录*/
	require("../mysql.class.php");

	function ck_login(){
		global $submit,$user,$password,$_sys,$code;
		$submit=$_POST['submit'];
		$user=fl_value($_POST['user']);
		$password=fl_value($_POST['password']);
		$code=$_POST['code'];
		if(!isset($submit)){
			msg('请从登录页面进入');
		}
		if(!empty($user)||empty($password)){
			msg('密码和用户名不可空');
		}
		if(!empty($_sys['safe_open'])){
			foreach ($_sys['safe_open'] as $key => $value) {
				if($value=='3'){
					if($code!=$_SESSION['code']){
						msg('验证码不正确');
					}
				}
			}
		}
		check_login($user,$password);
	}
	function check_login($user,$password){
		$rel=$$GLOBALS['mysql']->fetch_asc("select id,admin_name,admin_password,admin_purview,is_disable from ".DB_PRE."admin where admin_name='".$user."'limit 0, 1");
		$rel=empty($rel)?'':$rel[0];
		if(empty($rel)){
			msg('不存在','login.php');
		}

		$password=md5($password);
		if($password!=$rel['admin_password']){
				msg("输入密码不正确");
		}
		if($rel['is_disable']){
				msg("该账号无法登录了");
		}
		if(!isset($_SESSION)){
			session_start();
		}
		$_SESSION['admin']=$rel['admin_name'];
		$_SESSION['admin_purview']=$rel['admin_purview'];
		$_SESSION['admin_id']=$rel['admin_id'];
		$_SESSION['admin_time']=time();
		$_SESSION['login_in']=1;
		$_SESSION['login_time']=mktime();
		$ip=fl_value(get_ip());
		$ip=fl_value($ip);
		$_SESSION['admin_ip'];
		unset($rel);
		header("location:admin.html");
	}