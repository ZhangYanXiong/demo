<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<style type="text/css">
#yl{ width:200px; height:300px; background-image:url(images/1.png); background-size:200px 300px;}
#file{ width:200px; height:300px; float:left; opacity:0;}
</style>
</head>
 
<body>
 
<form id="sc" action="ylchuli.php" method="post" enctype="multipart/form-data" target="shangchuan">
   
   
  <input type="hidden" name="tp" value="" id="tp" />
   
  <div id="yl">
    <input type="file" name="file" id="file" onchange="document.getElementById('sc').submit()" />
  </div>
   
   
   
</form>
 
<iframe style="display:none" name="shangchuan" id="shangchuan">
</iframe>
 
 
</body>
 
<script type="text/javascript">
 
//回调函数,调用该方法传一个文件路径，改变背景图
function showimg(url)
{
  var div = document.getElementById("yl");
  div.style.backgroundImage = "url("+url+")";
   
  document.getElementById("tp").value = url;
}
 
</script>
 
</html>