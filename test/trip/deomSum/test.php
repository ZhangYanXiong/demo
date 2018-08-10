<?php 
$annexFolder = "annex"; 
$smallFolder = "smallimg"; 
$markFolder = "mark"; 
$includeFolder = "include"; 
require("./".$includeFolder."/upfile.php"); 
$img = new UPImages($annexFolder,$smallFolder,$includeFolder); 
$text = array("www.jb51.net","all rights reserved"); 
if(@$_GET["go"]) { 
$photo = $img->upLoad("upfile"); 
$img->maxWidth = $img->maxHeight = 350;//设置生成水印图像值 
$img->toFile = true; 
$newSmallImg = $img->smallImg($photo); 
$newMark = $img->waterMark($photo,$text); 
echo "<img src='".$newSmallImg."' border='0'><br><br>"; 
echo "<img src='".$newMark."' border='0'><br><br>"; 
echo "<a href='./test.php'>继续上传</a>"; 
} else { 
?> 
<form method="post" action="./test.php?go=go" enctype="multipart/form-data"> 
<input type="file" name="upfile"><br><br> 
<input type="submit" value="上传"> 
</form> 
<?php 
} 
?> 