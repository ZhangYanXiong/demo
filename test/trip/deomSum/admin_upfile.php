<?php
//这里上传 $upsize判断上传文件的大小
$uppath = "/images/"; //文件上传路径
//转换根目录的路径
if (strpos($uppath, "/") == 0)
{
  $i = 0;
  $thpath = $_SERVER["SCRIPT_NAME"];
  $thpath = substr($thpath, 1, strlen($thpath));
  while (strripos($thpath, "/") !== false)
  {
 $thpath = substr($thpath, strpos($thpath, "/") + 1, strlen($thpath));
 $i = ++$i;
  }
  $pp = "";
  for ($j = 0; $j < $i; ++$j)
  {
 $pp .= "../";
  }
  $uppaths = $pp . substr($uppath, 1, strlen($thpath));
}
$filename = date("y-m-d");
if (is_dir($uppaths . $filename) != TRUE)
  mkdir($uppaths . $filename, 0777);
$f = $_FILES['pic'];
if ($f["type"] != "image/gif" && $f["type"] != "image/pjpeg" && $f["type"] != "image/jpeg" && $f["type"] != "image/x-png")
{
  echo "<script>alert('只能上传图片格式的文件');window.close()</script>";
  return false;
}
//获得文件扩展名
$temp_arr = explode(".", $f["name"]);
$file_ext = array_pop($temp_arr);
$file_ext = trim($file_ext);
$file_ext = strtolower($file_ext);
//新文件名
$new_file_name = md5(date("YmdHis")) . '.' . $file_ext;
echo $dest = $uppaths . $filename . "/" . date("ymdhis") . "_" . 
$new_file_name; //设置文件名为日期加上文件名避免重复 上传目录
echo $dest1 = $uppath . $filename . "/" . date("ymdhis") . "_" . 
$new_file_name; //设置文件名为日期加上文件名避免重复
$r = move_uploaded_file($f['tmp_name'], $dest);
?>