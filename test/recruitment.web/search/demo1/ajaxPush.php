<?php
/**
 * Created by TXM.
 * Time: 2015/4/18 13:12
 * function:
 */
$filename = dirname(__FILE__).'/data.txt';
$isread_file = dirname(__FILE__).'/isread.txt';
$userfile = dirname(__FILE__).'/user.txt';
$get_user = $_GET['user'] == '1'?'2':'1';
$msg='';
while(1){
  $msg = file_get_contents($filename);
  $isread = file_get_contents($isread_file);
  $user = file_get_contents($userfile);
  //是对方发送的消息，设置消息已读，退出循环。
  if($isread == '0' && $get_user == $user){
    file_put_contents($isread_file,'1');
    break;
  }
  sleep(1);
}
echo json_encode(array('msg'=>$msg));
