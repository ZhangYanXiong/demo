<?php 
 /*查询数据库*/ 
	error_reporting(0);
	session_start();
	include("conn.php");
	$query="SELECT * from numbering id order by id desc";
	$result=mysqli_query($link,$query)or die("查询失败!");
	if($result==true){
		while($myrow=mysqli_fetch_array($result)){
?>
		<table>
			<tbody>
				<tr>
					<td colspan="2" align="center" valign="middle" class="">
					<span class="">编号：</span>
					<input type="text" name="name" id="name" value="<?php echo $myrow[id]; ?>" size="12" />
					</td>
					<td colspan="2" align="center" valign="middle" class="">
					<span class="">状态：</span>
					<input type="text" name="name" id="name" value="<?php echo $myrow[seat_status]; ?>" size="12" />
					</td>
				</tr>
			</tbody>
		</table>
	<?php
		}
		
	}
	?>
