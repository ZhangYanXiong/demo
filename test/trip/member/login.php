<?php
	/*会员登录*/
	require("../mysql.class.php");
	function save_login(){
		 global $submit,$user,$password,$_sys,$code;
		 $submit=$_POST['submit'];
		 $user=fl_value($_POST['user']);
		 $password=fl_value($_POST['password']);
		 $code=$_POST['code'];
		 if(empty($submit)){
		 	die("<script type=\"text/javascript\">alert('请先登录');location.href='../register.html';</script>");
		 }
		 	if(!empty($_sys['safe_open'])){
		 		foreach ($_sys['safe_open'] as $key => $value) {
		 			if($value=='2'){
		 				if($code!=$_SESSION['code']){
		 					die("<script type=\"text/javascript\">alert('验证码不正确');history.go(-1);</script>");
		 				}
		 			}
		 		}
		 	}
		 	if(empty($user)||empty($password)){
		 		die("<script type=\"text/javascript\">alert('用户和密码不能为空!');history.go(-1);</script>");
		 	}
		 	$password=md5($password);
		 	$sql="select*from".DB_PRE."member where member_user='{$user}'and member_password='{$password}'";
		 	if(!$GLOBALS['mysql']->fetch_rows($sql)){
		 		die("<script type=\"text/javascript\">alert('用户和密码不正确');history.go(-1);</script>");
		 	}
		 	$rel=$GLOBALS['mysql']->fetch_asc($sql);
		 	if($rel[0]['is_disable']){
		 		die("<script type=\"text/javascript\">alert('登录失败，账号被锁定');history.go(-1);</script>");
		 	}
		 	$_SESSION['member_user']=$rel[0]['member_user'];
		 	$_SESSION['login']="true";
		 	$_SESSION['id']=$rel[0]['id'];
		 	$_SESSION['purview']=$rel[0]['purview'];
		 	$m_time=time();
		 	$_SESSION['m_time']=$m_time;
		 	$m_ip=fl_value(get_ip());
		 	$_SESSION['m_ip']=$m_ip;
		 	$m_count=$rel[0]['member_count']+1;
		 	$sql="unpdate".DB_PRE."member set member_count={$m_count} where id".$rel[0]['id'];
		 	unset($rel);
		 	$GLOBALS['mysql']->query($sql);
		 	header("location:member.php");
	}