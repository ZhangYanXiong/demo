<?php 
 Class upload 
 { 
  var $upload_name; 
  var $upload_tmp_address; 
  var $upload_server_name; 
  var $upload_filetype ; 
  var $file_type; 
  var $file_server_address; 
  var $image_w=900;  //要显示图片的宽 
  var $image_h=350;  //要显示图片的高 
  var $upload_file_size; 
  var $upload_must_size= 50000; //允许上传文件的大小，自己设置 
  function upload_file() 
  { 
   $this->upload_name = $_FILES["file"]["name"];    //取得上传文件名 
   $this->upload_filetype = $_FILES["file"]["type"]; 
   $this->upload_server_name = date("Y_m_dH_i_s").$this->upload_name; 
   $this->upload_tmp_address = $_FILES["file"]["tmp_name"];    //取得临时地址 
   $this->file_type = array("image/gif","image/pjpeg");  //允许上传文件的类型 
   $this->upload_file_size = $_FILES["file"]["size"];  //上传文件的大小 
   if(in_array($this->upload_filetype,$this->file_type)) 
   { if($this->upload_file_size < $this->upload_must_size) 
    { 
        echo("上传成功，谢谢支持"); 
     $this->file_server_address = "D:\usr\www\html\upload/".$this->upload_server_name; 
        move_uploaded_file($this->upload_tmp_address,$this->file_server_address);//从TEMP目录移出 
        echo("<img src=$this->file_server_address width=$this->image_w height=$this->image_h/>");  //显示图片 

     
     } 
     else 
     { 
      echo("文件容量太大"); 
     } 
   } 
   else 
   { 
    echo("不支持此文件类型，请重新选择"); 
   } 

  }  

 } 
 $dd = new upload; 
 $dd->upload_file(); 
?>