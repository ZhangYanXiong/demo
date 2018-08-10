<?php
	require("../mysql.class.php");
	if(empty($_SESSION['member_user'])||empty($_SESSION['id'])||!$_SESSION['login']){
		die("<script type=\"text/javascript\">alert('请先登录');location.href='login.php';</script>");
	}
	$action=isset($action)?$action:'info';
	go_url($action);
	function info(){
		$sql="select*from".DB_PRE."member where id=".$_SESSION['id'];
		$rel=$$GLOBALS['mysql']->fetch_asc($sql);
		if(!empty($rel[0]['member_birth'])){
			$arr=explode('-',$rel[0]['member_birth']);
		}
		include('template/member_info.html');
	}

	//用户修改信息
	function save_info(){
		global $birthdayYear,$birthdayMonth,$birthdayDay,$sex,$mail,$qq,$tel,$phone,$submit;
		$birthdayYear=fl_value($_POST['birthdayYear']);
		$birthdayMonth=fl_value($_POST['birthdayMonth']);
		$birthdayDay=fl_value($_POST['birthdayDay']);
		$sex=fl_value($_POST['sex']);
		$mail=fl_value($_POST['mail']);
		$qq=fl_value($_POST['mail']);
		$tel=fl_value($_POST['mail']);
		$phone=fl_value($_POST['mail']);
		$submit=$_POST['submit'];
		if(!empty($qq)){
			if(!check_str($qq,'^[1-9][0-9]*$')){
				die("<script type=\"text/javascript\">alert('QQ号码不正确');history.go(-1);</script>");
			}
		}
		if(!empty($phone)){
			if(!check_str($phone,'^[1-9][0-9]*$')){
				die("<script type=\"text/javascript\">alert('手机必须为数字');history.go(-1);</script>");
			}
		}
		if(empty($submit)){
			die("<script type=\"text/javascript\">alert('请从表单提交');history.go(-1);</script>");
		}

		$birthdayYear.'-'.$birthdayMonth.'-'.$birthdayDay;
		$sql="update".DB_PRE."member set member_tel='{$tel}',member_phone='{$phone}',member_birth='{$birth}',member_sex=".fl_html($sex[0]).",member_qq='{$qq}'where id={$_SESSION['id']}";
		$GLOBALS['mysql']->query($sql);
		echo "<script type=\"text/javascript\">alert('修改成功');history.go(-1);</script>";
	}

	//会员咨询
	function save_ask(){
		$member_id=intval($_POST['member_id']);
		$title=fl_value($_POST['title']);
		$content=fl_value($_POST['content']);
		if(empty($member_id)){
			die("参数传递错误,请重新操作");
		}
		if(empty($title)||empty($content)){
			die("标题和内容不能为空");
		}
		$addtime=time();
		$sql="insert into".DB_PRE."ask(title,content,addtime,member) value('{$title}','{$content}','{$addtime}','{$member_id}')";
		$GLOBALS['mysql']->query($sql);
		echo"<script type=\"text/javascript\">alert('咨询添加成功');history.go(-1);</script>";
	}

	function ask(){
		global $member_id;
		$member_id=$_SESSION['id'];
		$sql="select*from".DB_PRE."ask where member=".intval($member_id)."order by addtime desc";
		$rel=$$GLOBALS['mysql']->fetch_asc($sql);
		include('template/member_ask.html');
	}

	//验证修改操作
	function save_xg(){
		global $id,$member_id,$content;
		$id=intval(fl_value($_POST['id']));
		$member_id=intval(fl_value($_POST['member_id']));
		$content=fl_value($_POST['$content']);
		if(empty($id)||empty($member_id)){
			die('传递的参数有错误，请重新操作');
		}
		if(empty($content)){
			die('内容不能为空');
		}
		$sql="update".DB_PRE."ask set content='{$content}' where id={$id}";
		$$GLOBALS['mysql']->query($sql);
		echo"<script type=\"text/javascript\">alert('咨询修改成功');location.href='?';</script>";
	}

	//修改密码
	function save_password(){
		global $password_use,$password_new,$password_new2;
		$password_use=trim(fl_value($_POST['password_use']));
		$password_new=trim(fl_value($_POST['password_new']));
		$password_new2=trim(fl_value($_POST['password_new2']));
		if(empty($password_use)||empty($password_new)||empty($password_new2)){
			die("<script type=\"text/javascript\">alert('用户和密码不能为空!');history.go(-1);</script>");
		}
		$sql="select member_password from".DB_PRE."member where id=".$_SESSION['id'];
		$rel=$$GLOBALS['mysql']-get_row($sql);
		if(md5($password_use)!=$rel){
			die("<script type=\"text/javascript\">alert('原始密码不正确!');history.go(-1);</script>");
		}
		if($password_new!=$password_new2){
			die("<script type=\"text/javascript\">alert('两次密码不同!');history.go(-1);</script>");
		}
		$sql="update".DB_PRE."member set member_password='".md5($password_new)."'where id=".$_SESSION['id'];
		$GLOBALS['mysql']->query($sql);
		echo"<script type=\"text/javascript\">alert('密码修改成功');location.href='?';</script>";
	}
	