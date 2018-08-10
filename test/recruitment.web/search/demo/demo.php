<?php
$provinces=array("beijing","tianjin","shanghai","chongqing","hebei","henan","heilongjiang","jilin","changchun",
  "shandong","anhui","shanxi","guangzhou","yunnan","hainan","xizang","qinghai","fujian","guizhou","jiangsu",
  "zhejiang","guangzhou","yunan","hainan","xizang","neimenggu","sichuan","gansu","ningxia","xianggang","aomen");
$tmp=$_GET['q'];
$val=array();
$k=0;
if (strlen($tmp)>0)
{
  for($i=0;$i<31;$i++){
    if(strpos($provinces[$i],$tmp)!==false){
       //传递值给val
       $val[$k]=$provinces[$i];
       //下标增加
       $k=$k+1;
    }
  }
  //遍历val数组
  for($j=0;$j<count($val);$j++)
  {
    echo $val[$j];
    echo "<br>";
  }
}
?>