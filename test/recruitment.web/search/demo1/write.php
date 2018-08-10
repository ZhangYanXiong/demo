<?php
/**
 * Created by TXM.
 * Time: 2015/4/18 13:13
 * function:
 */
$filename = dirname(__FILE__).'/data.txt';
$isread_file = dirname(__FILE__).'/isread.txt';
$user = dirname(__FILE__).'/user.txt';
//写入消息，消息未读，谁发送的消息
file_put_contents($filename,$_GET['msg']);
file_put_contents($isread_file,'0');
file_put_contents($user,$_GET['user']);
echo json_encode(array('sf'=>true));
?>