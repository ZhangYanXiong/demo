<?php
error_reporting(0);
 include_once'../conn.php';
 $query="SELECT comp_city from company";
 $result=mysqli_query($link,$query)or die("查询失败！");
 /*
 mysqli_num_rows()
 :获取结果集中行的数目
  */ 
 $provinces[]=array();
 while ($myrow=mysqli_fetch_array($result)) {
     $provinces[]=$myrow[comp_city];
 }
 /*for($i=1;$i<count($provinces);$i++){
    echo "城市：".$provinces[$i];
    echo "<br>";
 }*/
$tmp=$_GET['q'];
$val=array();
$k=0;
/*
strlen()
:获取数组的大小
 */ 
if (strlen($tmp)>0)
{
  for($i=1;$i<31;$i++){
    /*
    strpos()
    :查询字符串首次出现的位置
     */ 
    if(strpos($provinces[$i],$tmp)!==false){
       //传递值给val
       $val[$k]=$provinces[$i];
       //下标增加
       // $k=$k+1;
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