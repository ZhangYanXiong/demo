<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>无标题文档</title>  
<style type="text/css">  
    table{  
        border: 1px solid black;  
        border-color:#F06;  
        padding:10px;  
        border-collapse:collapse;  
    }  
    table tr th{  
        border: 1px solid black;  
        border-color:#F06;  
        padding:10px;  
        border-collapse:collapse;  
    }  
    table tr td{  
        border: 1px solid black;  
        border-color:#F06;  
        padding:10px;  
        border-collapse:collapse;  
    }  
</style>  
</head>  
  
<body>  
<center>  
<table>  
<caption>成绩列表</caption>  
<tr><th>编号</th><th>姓名</th><th>邮箱</th><th>成绩</th><th>时间</th></tr>  
<?php  
    //header("Content-Type:text/html;charset=utf-8");//设置页面字符编码  
    // 常量参数  
    define("DB_HOST", 'localhost');  
    define("DB_USER", 'root');  
    define("DB_PWD",'');  
    define("DB_NAME", 'school');  
  
    // 第一步，连接数据库  
    $conn = mysql_connect('localhost','root','') or die('数据库连接失败，错误信息：'.mysql_error());  
      
    // 第二步，选择指定的数据库，设置字符集  
    mysql_select_db(DB_NAME,$conn) or die('数据库错误，错误信息：'.mysql_error());  
    mysql_query('SET NAMES UTF8') or die('字符集设置错误：'.mysql_error());  
      
    //新增数据  
    // $query = "INSERT INTO grade(name,email,point,regdate)  
    // VALUES('护士','hs@qq.com',67,NOW())";  
    // mysql_query($query) or die('新增错误：'.mysql_error());  
  
    // 修改数据  
    // $query = 'UPDATE grade SET point = 87 WHERE id = 7';  
    // @mysql_query($query) or die('修改错误：'.mysql_error());  
  
    //删除数据  
    // $query = 'DELETE FROM grade WHERE id = 7';  
    // @mysql_query($query) or die('删除错误：'.mysql_error());  
  
    // 显示数据  
    $query = 'SELECT * FROM grade';  
    $result = mysql_query($query) or die('SQL语句错误：'.mysql_error());  
      
    // 把结果集转换成数组赋值给$row,如果有数据为真  
    while(!!$row = mysql_fetch_array($result)){  
        echo"<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>".$row["email"]."</td><td>".$row["point"]."</td><td>".$row["regdate"]."</td><tr>";  
    }  
  
    mysql_close($conn);  
?>  
</table>  
<a href="#">返回</a>  
  
</center>  
</body>  
</html>  