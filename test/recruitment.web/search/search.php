<?php
error_reporting(0);
 include_once'../conn.php';
 $query="SELECT * from addwork";
 $result_n=mysqli_query($link,$query)or die("查询失败！");
 $row=mysqli_num_rows($result_n);
 $provinces[]=array();
 $query="SELECT addr,pos from addwork";
 $result=mysqli_query($link,$query)or die("查询失败！");
 for ($i=0; $i <$row; $i++) { 
 	$myrow=mysqli_fetch_row($result);
 	for ($j=0; $j <count($myrow) ; $j++) { 
 		$provinces[]=$myrow[$j];
 	}
 }
$city=$_POST['city'];
$pos=$_POST['pos'];
$c=$_POST['c'];
$p=$_POST['p'];
if($c=="c"){
	$tmp=$city;
}else{
	$tmp=$pos;
}
$val=array();
$k=0;
if (strlen($tmp)>0)
{
  for($i=1;$i<31;$i++){
    if(strpos($provinces[$i],$tmp)!==false){
       $val[$k]=$provinces[$i];
    }
  }
  for($j=0;$j<count($val);$j++)
  {
    echo $val[$j];
  }
}
?>