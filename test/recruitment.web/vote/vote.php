<?php
	error_reporting(E_ALL||E_NOTICE);
	session_start();
	include '../conn.php';
	$vote=$_POST['vote'];
	$sum=0;
	$arr=Array();
	$query="SELECT workEN,wage,addre,prospects from vote";
	$result=mysqli_query($link,$query)or die("查询失败3!");
	$row=mysqli_fetch_array($result);
	if($result&&$row!=''){
		for($i=0;$i<4;$i++){
			$sum+=$row[$i];
		}
		$query="UPDATE vote SET sum='".$sum."'";
		$result=mysqli_query($link,$query)or die("修改失败!");
		$query="SELECT sum from vote";
		$result=mysqli_query($link,$query)or die("查询失败!");
		$rowS=mysqli_fetch_array($result);
		for($i=0;$i<4;$i++){
			$arr[$i]=($row[$i]/$rowS[0]);
		};
		echo json_encode($arr);
	}else{
		echo "不存在！";
	}
	switch ($vote) {
		case 1:
			$query="SELECT workEN from vote";
			$result=mysqli_query($link,$query)or die("查询失败!");
			$row=mysqli_fetch_array($result);
			if($result&&$row!=''){
				$voteSum=$row[0]+1;
				$query="UPDATE vote SET workEN='".$voteSum."'";
				$result=mysqli_query($link,$query)or die("查询失败!");
				if($result==true){
					echo "成功！";
				}else{
					echo "失败！";
				}
			}else{
				echo "不存在！";
			}
			break;
		case 2:
			$query="SELECT wage from vote";
			$result=mysqli_query($link,$query)or die("查询失败!");
			$row=mysqli_fetch_array($result);
			if($result&&$row!=''){
			$voteSum=$row[0]+1;
				$query="UPDATE vote SET wage='".$voteSum."'";
				$result=mysqli_query($link,$query)or die("查询失败!");
				if($result==true){
					echo "成功！";
				}else{
					echo "失败！";
				}
			}else{
				echo "不存在！";
			}
			break;
		case 3:
			$query="SELECT addre from vote";
			$result=mysqli_query($link,$query)or die("查询失败!");
			$row=mysqli_fetch_array($result);
			if($result&&$row!=''){
				$voteSum=$row[0]+1;
				$query="UPDATE vote SET addre='".$voteSum."'";
				$result=mysqli_query($link,$query)or die("修改失败!");
				if($result==true){
					echo "成功！";
				}else{
					echo "失败！";
				}
			}else{
				echo "不存在！";
			}
			break;
		case 4:
			$query="SELECT prospects from vote";
			$result=mysqli_query($link,$query)or die("查询失败!");
			$row=mysqli_fetch_array($result);
			if($result&&$row!=''){
				$voteSum=$row[0]+1;
				$query="UPDATE vote SET prospects='".$voteSum."'";
				$result=mysqli_query($link,$query)or die("修改失败!");
				if($result==true){
					echo "成功！";
				}else{
					echo "失败！";
				}
			}else{
				echo "不存在！";
			}
			break;
	}
?>