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
<!-- 
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
		</table> -->
	<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">	
	<title></title>
	<link rel="stylesheet" href="bootstrap.min.css"/>
	<script src="jquery-1.7.2.js"></script>
	<script src="bootstrap.js"></script>

	<script src="../vue.js"></script>
	<script type="text/javascript">
		window.onload=function(){
			new Vue({
				el:'#box',
				data:{
					myData:[],
					username:'',
					age:''
				},
				methods:{
					add:function(){
						//alert(1);
						this.myData.push({
							name:this.username,
							age:this.age,
							nowIndex:-100
						});
						this.username='';
						this.age='';
					},
					deleteMsg:function(n){
						
						//alert(n);
						if(n==-2){
							this.myData=[];
						}else{
							//删除指定的一项
							this.myData.splice(n,1);
						}
					}
				}
			});
		};
	</script>
</head>
<body>
	<!-- v-show隐藏显示指令 -->
	<div class="container" id="box">
		<form role="from">
			<div class="form-group">
				<label for="username">用户名:</label>
				<input type="text" id="username" class="form-control" placeholder="输入用户名" v-model="username" />
				<label for="age">年龄:</label>
				<input type="text" id="age" class="form-control" placeholder="输入年龄" v-model="age">
			</div>
				<input type="button" name="" value="添加" class="btn btn-primary" v-on:click="add()"/>
				<input type="reset" value="重置" class="btn btn-danger"/>
		</form>
		<hr>
		<table class="table table-bordered table-hovered">
			<caption class="h3">用户信息表</caption>
				<tr class="text-danger">
					<th class="text-center">序号</th>
					<th class="text-center">座位号</th>
					<th class="text-center">状态</th>
					<th class="text-center">操作</th>

				</tr>
				<tbody>
				<tr class="text-center" v-for="(item,index) in myData">
					<td>{{index+1}}</td>
					<td>{{item.name}}</td>
					<td>{{item.age}}</td>
					<td>
						<!--data-toggle="modal" data-target="#layer" 转到模态框  -->
						<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">删除</button>
						<button class="btn btn-primary btn-sm">添加</button>
					</td>
				</tr>
				<tr v-show="myData.length!=0">
					<td colspan="4" class="text-right">
						<button class="btn btn-danger " data-toggle="modal" data-target="#layer" v-on:click="nowIndex=-2" >全部删除</button>
					</td>
				</tr>
				<tr class="text-center" v-show="myData.length==0">
					<td  colspan="4" class="text-muted">
						<p>暂无数据</p>
					</td>
				</tr>
			</tbody>
		</table>
		<!--模态框-->
		<!-- role说明标签的语义 -->
		<div role="dialog" class="modal fade" id="layer">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">确认删除?</h4>
					</div>
					<div class="modal-body text-right">
						<button class="btn btn-primary btn-sm" data-dismiss="modal" >取消</button>
						<!-- data-dismiss="modal" 模态框消失-->
						<button class="btn btn-danger btn-sm" data-dismiss="modal" v-on:click="deleteMsg(nowIndex)">确定</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
	<?php
		}
		
	}
	?>
