<?php	
    error_reporting(E_ALL||E_NOTICE);
	session_start();
	include '../conn.php';
	$arr[]=Array();
	$query="SELECT com,addr,pos,expe,wage,sill,edu,timer from addwork";
	$result=mysqli_query($link,$query)or die("查询失败!");
	$row=mysqli_fetch_array($result);
	if($result&&$row!=''){
		for($i=0;$i<8;$i++){
			$arr[$i]=$row[$i];
		};
		echo json_encode($arr);
	}else{
		echo "不存在！";
	}
?>