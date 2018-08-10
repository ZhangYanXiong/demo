<?php
 
if($_FILES["file"]["error"])
{
  echo $_FILES["file"]["error"];
}
else
{
  if(($_FILES["file"]["type"]=="image/jpeg" || $_FILES["file"]["type"]=="image/png")&& $_FILES["file"]["size"]<1024000)
  {
    $fname = "./images/".date("YmdHis").$_FILES["file"]["name"];  
     
    $filename = iconv("UTF-8","gb2312",$fname);
     
    if(file_exists($filename))
    {
      echo "<script>alert('该文件已存在！');</script>";
    }
    else
    {
      move_uploaded_file($_FILES["file"]["tmp_name"],$filename);
       
       
      $delurl = iconv("UTF-8","gb2312",$_POST["tp"]);
      unlink($delurl); //删除文件
       
      echo "<script>parent.showimg('{$fname}');</script>";
    }
     
  }
}