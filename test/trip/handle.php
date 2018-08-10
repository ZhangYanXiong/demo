<?php

$imgtype = array(
  'gif'=>'gif',
  'png'=>'png',
  'jpg'=>'jpeg',
  'jpeg'=>'jpeg'
); //图片类型在传输过程中对应的头信息
$message = $_POST['message']; //接收以base64编码的图片数据
$filename = $_POST['filename']; //接收文件名称
$ftype = $_POST['filetype']; //接收文件类型
//首先将头信息去掉，然后解码剩余的base64编码的数据
$message = base64_decode(substr($message,strlen('data:image/'.$imgtype[strtolower($ftype)].';base64,')));
$filename = $filename.".".$ftype;
$furl = "F:/now/";
//开始写文件
$file = fopen($furl.$filename,"w");
if(fwrite($file,$message) === false){
  echo json_encode(array('code'=>1,'con'=>'failed'));
  exit;
}
echo json_encode(array('code'=>0,'con'=>$filename));
