<?php	
    error_reporting(E_ALL||E_NOTICE);
	session_start();
	include '../conn.php';
	$data=$_POST['json'];
	$query="insert into addwork(com,addr,pos,expe,edu,wage,sill) values ('".$data["com"]."','".$data["addr"]."','".$data["pos"]."','".$data["expe"]."','".$data["edu"]."','".$data["wage"]."','".$data["sill"]."')";
	$result=mysqli_query($link,$query)or die("插入失败!");
	if($result==true){
		echo "成功！";
	}else{
		echo "失败！";
	}
	
?>