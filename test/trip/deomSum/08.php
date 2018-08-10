<?php
// 注册表单的姓名
$name="";
$nameErr="";
if ($_SERVER["REQUEST_METHOD"]=="POST") {
  if (empty($_POST['name'])) {
  }else{
    $name=$_POST['name'];
    if (!preg_match("/^[a-zA-Z]*$/", $name)) {
      $nameErr="只允许字母和空格";
    }else{
      echo '姓名'.$name;
    }
  }
  
  // 文件上传
    if ((($_FILES["file"]["type"] == "image/gif")
    || ($_FILES["file"]["type"] == "image/jpeg")
    || ($_FILES["file"]["type"] == "image/pjpeg"))
    && ($_FILES["file"]["size"] < 2000000))
    {
  
      if ($_FILES["file"]["error"]>0) {
        echo "错误：".$_FILES["file"]["error"]."<br/>";
  
      }else{
        echo "upload:".$_FILES["file"]["name"]."<br/>";
        echo "type:".$_FILES["file"]["type"]."<br/>";
        echo "size:".$_FILES["file"]["size"]."<br/>";
        echo "stored in:".$_FILES["file"]["tmp_name"];
      }  
    }else{
      if (file_exists("weiwei/".$_FILES["file"]["name"])) {
        echo $_FILES["file"]["name"]."上传成功.";
      }else{
         move_uploaded_file($_FILES["file"]["tmp_name"],
       "weiwei/" . $_FILES["file"]["name"]);
       echo "Stored in: " . "weiwei/" . $_FILES["file"]["name"];
      }
  
  echo "上传成功";
  
}
  
}    
?>