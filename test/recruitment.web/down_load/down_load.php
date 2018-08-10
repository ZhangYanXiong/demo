<?php
error_reporting(0);
include '../conn.php';
header('Content-type:text/html;charset="utf-8"');
/*文件处理*/ 
$upload_dir='uploads/';
/*
strtolower()
:把字符串变为小写字母
 */ 
if(strtolower($_SERVER['REQUEST_METHOD'])!='post'){
	exit_status(array('code='=>1,'msg'=>'错误的提交方式!'));
}
/*
array_key_exists()
:检查给定的键名或索引是否存在于数组中
 */ 
if(array_key_exists('file',$_FILES) && $_FILES['file']['error']==0){
	$myFile=$_FILES['file'];
	/*
	move_uploaded_file()
	:将上传的文件移动到新位置
	 */ 
	
	if(move_uploaded_file($myFile['tmp_name'],$upload_dir.$myFile['name'])){
		$email=$_POST['email'];
		exit_status(array('code='=>0,'msg'=>'上传成功！','url'=>$upload_dir.$myFile['name'],'email'=>$email));
		
		// $query="SELECT email from company where email='".$email."'";
		// $result=mysqli_query($link,$query);	
	}
}
echo $_FILES['file']['error'];
exit_status(array('code'=>1,'msg'=>'出现了一些错误'));

function exit_status($str){
	echo json_encode($str);
	exit;
}