<?php
include("smarty.php");
	$content="提醒!,注意用户名密码外漏!";
	$title="后台登录";
	$smarty->assign('content',$content);
	$smarty->assign('title',$title);
	$smarty->dispaly("tempales/login.html");