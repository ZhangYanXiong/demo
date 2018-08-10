<?php
	/*用户登录*/
	require("../mysql.class.php");
	$user=fl_value($_POST['user']);
	$password=fl_value($_POST['password']);
	$user=fl_value($_POST['user']);
	$user=fl_value($_POST['user']);
	$user=fl_value($_POST['user']);
	$user=fl_value($_POST['user']);
	if($_sys['web_member'][0]){
		die("<script type=\"text/javascript\">alert('会员已经暂停注册');history.go(-1);</script>");
	}
	if(!preg_match($user,'^[a-zA-Z][a-zA-Z0-9]{3,15}$')){die("<script type=\"text/javascript\">alert('用户名只能是字母和数字,4位以上长度');history.go(-1);</script>");}
	if(!preg_match($nich,'^[a-zA-Z][a-zA-Z0-9]{3,15}$')){die("<script type=\"text/javascript\">alert('昵称只能是数字字符,4位以上长度');history.go(-1);</script>");}
	if(empty($password)||empty($password2)){die("<script type=\"text/javascript\">alert('密码不能为空!');history.go(-1);</script>");}
	if($password=$password2){die("<script type=\"text/javascript\">alert('两次密码不一样!');history.go(-1);</script>");}
	if(!preg_match($mail,'^[0-9a-z]+@(([0-9a-z]+)[.])+[a-z]{2,3}$')){
		die("<script type=\"text/javascript\">alert('邮箱不正确');history.go(-1);</script>");
	}
	if(!empty($_sys['member_no_name'])){
		$no_name=explode('|',$_sys['member_no_name']);
	}
	if(is_array($no_name)){
		if(in_array($user, $no_name)){
			die("<script type=\"text/javascript\">alert('【".$user."】该用户名不能注册');history.go(-1);</script>");
		}
	}

	//验证验证码是否正确
	if(!empty($_sys['safe_open'])){
		foreach ($_sys['safe_open'] as $key => $value) {
			if($value=='1'){
				if($code!=$_SESSION['code']){
					die("<script type=\"text/javascript\">alert('验证码不正确');history.go(-1);</script>");
				}
			}
		}
	}
	$sql="select id form ".DB_NAME."member where member_user='{$user}'";
	if($GLOBALS['mysql']->fetch_rows($sql)){
		die("用户名已存在!");
	}
	if(!$_sys['member_mail'][0]){
		$sql="select id form".DB_NAME."member where member_mail='{$mail}'";
		if($GLOBALS['mysql']->fetch_rows($sql)){
		die($mail."邮箱被用过!");}
	}
	$addtime=time();
	$password=md5($password);
	$sql="insert into".DB_NAME."member(member_user,member_password,member_nich,member_mail,member_purview) values('{$user}','{$password}','{$nich}','{$mail}',1)";
		$GLOBALS['mysql']->query($sql);
		$last_id=$GLOBALS['mysql']->insert_id();
		$ip=fl_value(get_ip());
		$sql="update".DB_NAME."member set member_time='{$addtime}',member_ip='{$ip}'where id={$last_id}";
		$GLOBALS['mysql']->query($sql);
		echo "<script type=\"text/javascript\">alert('注册成功');location.href='../register.html';</script>";
	
?>