<?php 
 /*查询数据库*/ 
	error_reporting(0);
	session_start();
	include("conn.php");
?>		
<!DOCTYPE html>
<html>
 <head>
 	<title>座位表</title>
	<meta	http-equiv="content-type" content="text/html;charset=UTF-8"/>
    <meta name="Keywords" content="关键词"/>
 	<meta name="Description" content="描述"/>
 	<meta name="viewport" content="width=device-width,initial-scale=1" />
 	<meta name=”refresh” content="5,oper2.php"/>
	
	<script src="bootstrap-3.3.7-dist/js/jquery.js"></script>
	<script src="bootstrap-3.3.7-dist/js/bootstrap.js"></script>
	
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/base.css"/>
	<link rel="stylesheet" type="text/css" href="css/index.css"/>

    <style type="text/css">
    	.dis-b{
			display: block;
		}
		.dis-n{
			display: none;
		}
		.mar-l-10{
			margin-left: -10px;
		}
    </style>
</head>
<body>
	<div class="container container-fluid box">
		<div class="keith nav nav-tabs container" id="tab-box">
       		<ul class="text-center container">
		       <li class="text-center">自科</li>
		       <li class="text-center">社科</li>
		       <li class="text-center">文学</li>
		       <li class="text-center">历史</li>
       		</ul>
   		</div>
   		<div class="tab-content bg-info" id="con-box">
   			 <!-- 1 -->
			<div class="center-block">
				<!-- 介绍 -->
		        <div class="text-center container">
					<h3 class="text-center">我们的团队</h3>
		                <div class="text-center">
		                    <div class="img-circle">
		                        <img src="images/bg.jpg" alt="" class="img-circle img-responsive img-thumbnail" />
		                    </div>
			                <p class="text-primary">
			                    &nbsp;&nbsp; &nbsp;&nbsp;人生需要努力，但也偶尔给自己按下暂停键，走的太多会错失很多风景。慢慢走人生才更有动力，海水味道的空气，和蔼可亲的台腔，吃不完的美食，爱上这座城市啦，这里的美食、美景、美人。此生要来一次台湾！继续攒钱为下一次旅途。 DAY13月4日北京首都国际机场T3航站楼办理登机出境手续后，乘坐八点的国泰航空豪华客机飞往香港转机前往台北桃园机场，抵达后入住桃园酒店！饱岛台湾，夜市琳琅的小吃，香甜可口的水果，丰富可
			                </p>
		                </div>
				</div>
   				<!-- 表 -->
				<table class="table table-bordered table-hovered" id="table-box">
					<caption class="text-center"><button class="btn btn-success" id="distb">座位分布图</button></caption>
					<tbody>
						
						<?php
							$query="SELECT seat_status,id from numbering id";
							$result=mysqli_query($link,$query)or die("查询失败!");
							$arr=array();
							$arri=array();
							if($result==true){
								while($myrow=mysqli_fetch_array($result)){
								$arr[]=$myrow[id];
								$arri[]=$myrow[seat_status];
								}
							}	
						?>
						<tr class="text-danger">
							<th>
								<div class="text-center row">
									<div class="col-md-4 col-xs-1">序号</div>
									<div class="col-md-4 col-xs-1">状态</div>
									<div class="col-md-4 col-xs-1">操作</div>
								</div>
							</th>
							<th>
								<div class="text-center row">
									<div class="col-md-4 col-xs-1">序号</div>
									<div class="col-md-4 col-xs-1">状态</div>
									<div class="col-md-4 col-xs-1">操作</div>
								</div>
							</th>
							<th>
								<div class="text-center row">
									<div class="col-md-4 col-xs-1">序号</div>
									<div class="col-md-4 col-xs-1">状态</div>
									<div class="col-md-4 col-xs-1">操作</div>
								</div>
							</th>
							<th>
								<div class="text-center row">
									<div class="col-md-4 col-xs-1">序号</div>
									<div class="col-md-4 col-xs-1">状态</div>
									<div class="col-md-4 col-xs-1">操作</div>
								</div>
							</th>
						</tr>
						<tr class="text-danger">
							<th class="text-danger">
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row "><?php echo $arr[0]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4 mar-l-10">
										<div class="text-center row "><button class="btn btn-success btn-xs" id="btnv"><?php echo $arri[0]; ?></button></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row ">
											<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#layer">预约</button>
										</div>
									</div>
								</div>
							</th>
							<th class="text-danger">
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-4 ">
										<div class="text-center row mar-l-5"><?php echo $arr[1]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4 mar-l-10">
										<div class="text-center row "><button class="btn btn-success btn-xs" id="btnv"><?php echo $arri[1]; ?></button></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row ">
											<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#layer">预约</button>
										</div>
									</div>
								</div>
							</th>
							<th class="text-danger">
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-4 ">
										<div class="text-center row mar-l-5"><?php echo $arr[2]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4 mar-l-10">
										<div class="text-center row "><button class="btn btn-success btn-xs" id="btnv"><?php echo $arri[2]; ?></button></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row ">
										<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
										</div>
									</div>
								</div>
							</th>
							<th class="text-danger">
								<div class="text-center row ">
									<div class="text-center col-md-4 col-xs-4 ">
										<div class="text-center row"><?php echo $arr[3]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4 mar-l-10">
										<div class="text-center row "><button class="btn btn-success btn-xs" id="btnv"><?php echo $arri[3]; ?></button></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row ">
										<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
										</div>
									</div>
								</div>
							</th>
						</tr>
						<tr class="text-danger">
							<th class="text-danger">
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row "><?php echo $arr[4]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4 mar-l-10">
										<div class="text-center row "><button class="btn btn-success btn-xs" id="btnv"><?php echo $arri[4]; ?></button></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row ">
											<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
										</div>
									</div>
								</div>
							</th>
							</th>
							<th class="text-danger">
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-4">					
										<div class="text-center row "><?php echo $arr[5]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4 mar-l-10">
										<div class="text-center row "><button class="btn btn-success btn-xs"><?php echo $arri[5]; ?></button></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row ">
										<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
										</div>
									</div>
								</div>
							</th>
							<th class="text-danger">
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row "><?php echo $arr[6]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4 mar-l-10">
										<div class="text-center row "><button class="btn btn-success btn-xs" id="btnv"><?php echo $arri[6]; ?></button></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row ">
										<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
										</div>
									</div>
								</div>
							</th>
							<th class="text-danger">
								<div class="text-center row ">
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row "><?php echo $arr[7]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4 mar-l-10">
										<div class="text-center row "><button class="btn btn-success btn-xs" id="btnv"><?php echo $arri[7]; ?></button></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row ">
										<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
										</div>
									</div>
								</div>
							</th>
						</tr>
						<tr class="text-danger">
							<th class="text-danger">
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row "><?php echo $arr[8]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4 mar-l-10">
										<div class="text-center row "><button class="btn btn-success btn-xs" id="btnv"><?php echo $arri[8]; ?></button></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row ">
											<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
										</div>
									</div>
								</div>
							</th>
							<th class="text-danger">
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row "><?php echo $arr[9]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4 mar-l-10">
										<div class="text-center row "><button class="btn btn-success btn-xs" id="btnv"><?php echo $arri[9]; ?></button></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row ">
										<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
										</div>
									</div>
								</div>
							</th>
							<th class="text-danger">
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row "><?php echo $arr[10]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4 mar-l-10">
										<div class="text-center row "><button class="btn btn-success btn-xs" id="btnv"><?php echo $arri[10]; ?></button></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row ">
										<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
										</div>
									</div>
								</div>
							</th>
							<th class="text-danger">
								<div class="text-center row ">
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row "><?php echo $arr[11]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4 mar-l-10">
										<div class="text-center row "><button class="btn btn-success btn-xs" id="btnv"><?php echo $arri[11]; ?></button></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row ">
										<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
										</div>
									</div>
								</div>
							</th>
						</tr>
						<tr class="text-danger">
							<th class="text-danger">
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row "><?php echo $arr[12]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4 mar-l-10">
										<div class="text-center row "><button class="btn btn-success btn-xs" id="btnv"><?php echo $arri[12]; ?></button></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row ">
										<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
										</div>
									</div>
								</div>
							</th>
							<th class="text-danger">
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row "><?php echo $arr[13]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4 mar-l-10">
										<div class="text-center row "><button class="btn btn-success btn-xs" id="btnv"><?php echo $arri[13]; ?></button></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row ">
										<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
										</div>
									</div>
								</div>
							</th>
							<th class="text-danger">
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row "><?php echo $arr[14]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4 mar-l-10">
										<div class="text-center row "><button class="btn btn-success btn-xs" id="btnv"><?php echo $arri[14]; ?></button></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row ">
										<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
										</div>
									</div>
								</div>
							</th>
							<th class="text-danger">
								<div class="text-center row ">
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row "><?php echo $arr[15]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4 mar-l-10">
										<div class="text-center row "><button class="btn btn-success btn-xs" id="btnv"><?php echo $arri[15]; ?></button></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row ">
										<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
										</div>
									</div>
								</div>
							</th>
						</tr>
						<tr class="text-danger">
							<th class="text-danger">
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row "><?php echo $arr[16]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4 mar-l-10">
										<div class="text-center row "><button class="btn btn-success btn-xs" id="btnv"><?php echo $arri[16]; ?></button></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row ">
										<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
										</div>
									</div>
								</div>
							</th>
							<th class="text-danger">
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row "><?php echo $arr[17]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4 mar-l-10">
										<div class="text-center row "><button class="btn btn-success btn-xs" id="btnv"><?php echo $arri[17]; ?></button></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row ">
										<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
										</div>
									</div>
								</div>
							</th>
							<th class="text-danger">
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row "><?php echo $arr[18]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4 mar-l-10">
										<div class="text-center row "><button class="btn btn-success btn-xs" id="btnv"><?php echo $arri[18]; ?></button></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row ">
										<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
										</div>
									</div>
								</div>
							</th>
							<th class="text-danger">
								<div class="text-center row ">
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row "><?php echo $arr[19]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4 mar-l-10">
										<div class="text-center row "><button class="btn btn-success btn-xs" id="btnv"><?php echo $arri[19]; ?></button></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row ">
										<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
										</div>
									</div>
								</div>
							</th>
						</tr>
					</tbody>
				</table>
				<!--模态框-->

				<!-- 不能预约 -->
				<div role="dialog" class="modal fade" id="layer0">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">此座位有人，请您重新选择！</h4>
							</div>
							<div class="modal-body text-right">
								<button class="btn btn-primary btn-sm" data-dismiss="modal" >取消</button>
							</div>
						</div>
					</div>
				</div> 
				<!-- 是否预约 -->
				<div role="dialog" class="modal fade" id="layer1">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">确认预约?</h4>
							</div>
							<div class="modal-body text-right">
								<button class="btn btn-primary btn-sm" data-dismiss="modal" id="btn-goes">取消</button>
								<!-- data-dismiss="modal" 模态框消失-->
								<button class="btn btn-danger btn-sm" data-dismiss="modal" id="btn-go">确定</button>
							</div>
						</div>
					</div>
				</div>
				<!-- 预约成功 -->
				<div role="dialog" class="modal fade" id="layer2">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">预约成功！</h4>
							</div>
							<div class="modal-body text-right">
								<button class="btn btn-primary btn-sm" data-dismiss="modal" >确定</button>
							</div>
						</div>
					</div>
				</div> 
				<!-- 座位分布图 -->
				<div role="dialog" class="modal fade" id="layer3">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title text-center">座位分布图</h4>
							</div>
							<div class="modal-body clearfix">
								<ul class="pull-left">
									<li><button class="btn btn-info">&nbsp;&nbsp;1</button></li>
									<li><button class="btn btn-info">&nbsp;&nbsp;2</button></li>
									<li><button class="btn btn-info">&nbsp;&nbsp;3</button></li>
									<li><button class="btn btn-info">&nbsp;&nbsp;4</button></li>
									<li><button class="btn btn-info">&nbsp;&nbsp;5</button></li>
									<li><button class="btn btn-info">&nbsp;&nbsp;6</button></li>
									<li><button class="btn btn-info">&nbsp;&nbsp;7</button></li>
									<li><button class="btn btn-info">&nbsp;&nbsp;8</button></li>
									<li><button class="btn btn-info">&nbsp;&nbsp;9</button></li>
									<li><button class="btn btn-info">10</button></li>
								</ul>
								<ul class="pull-right">
									<li><button class="btn btn-info">11</button></li>
									<li><button class="btn btn-info">12</button></li>
									<li><button class="btn btn-info">13</button></li>
									<li><button class="btn btn-info">14</button></li>
									<li><button class="btn btn-info">15</button></li>
									<li><button class="btn btn-info">16</button></li>
									<li><button class="btn btn-info">17</button></li>
									<li><button class="btn btn-info">18</button></li>
									<li><button class="btn btn-info">19</button></li>
									<li><button class="btn btn-info">20</button></li>
								</ul>
							</div>
							<div class="modal-footer text-right">
								<button class="btn btn-primary btn-sm" data-dismiss="modal" >退出</button>
							</div>
						</div>
					</div>
				</div> 
			</div>

			<!-- 2 -->
			<div>
				1
			</div>

			<!-- 3 -->
			<div>
				2
			</div>

			<!-- 3 -->
			<div>
				3
			</div>
		</div>
	</div>
	<!-- js部分 -->
	<!-- <script>setTimeout("location.href='oper2.php'",6000)</script> -->
	<script type="text/javascript">
		window.onload=function(){
			var tab_box=document.getElementById('tab-box');
			var tab_li=tab_box.getElementsByTagName('li');
			var con_box=document.getElementById('con-box');
			var con_div=con_box.children;
			for(var i=0; i<tab_li.length;i++){
				tab_li[i].index=i;
			}
			for(var i=1; i<con_div.length;i++){
				con_div[i].className="dis-n";
			}
			for(var i=0;i<tab_li.length;i++){
				tab_li[i].onclick=function (){
					for(var i=0;i<con_div.length;i++){
						tab_li[i].className=" ";
						con_div[i].className="dis-n";
					};
					this.className="box";
					con_div[this.index].className="center-block";
				};
			}
			/*是否可预约*/ 
			var table_box=document.getElementById('table-box');
			var th_box=table_box.getElementsByTagName('th');
			for(var i=4;i<th_box.length;i++){
					btn=th_box[i].getElementsByTagName('button');
					if(btn[0].innerHTML==0){
						btn[0].className="btn-success";
					}else{
						btn[0].className="btn-danger";
					}
					btn[1].onclick=function(){
						var parent=this.parentNode.parentNode.parentNode;
						var brothers=parent.children;
						var broN=brothers[0].children;
						 num=broN[0].innerHTML;
						/*获取状态*/ 
						var brother=brothers[1].children;
						var broS=brother[0].children;
						 sta=broS[0].innerHTML;	
						if(sta==1){
							// alert("此座位有人，请您重新选择！");
							$(function () { $('#layer0').modal({
     							keyboard: true
 							 })});

						}else{
							 $(function () { $('#layer1').modal({
     							keyboard: true
 							 })});
						}
					};
			}
			/*预约操作*/ 
			var btn_go=document.getElementById('btn-go');
			btn_go.onclick=function(ev){
				var oEvent=ev||event;
				// 阻止事件冒泡
				oEvent.cancelBubble=true;
				$('#layer1').modal('hide');
				changeSql(num,sta);
				$(function () { $('#layer2').modal({
     				keyboard: true
 				})});
 				window.location.href=window.location.href;
			};
			/*座位分布图*/ 
			var distb=document.getElementById('distb');
			distb.onclick=function(){
				$(function () { $('#layer3').modal({
     				keyboard: true
 				})});
			}

		};
		function changeSql(num,sta){
			$.ajax({
 				type: "POST",
 				url: "oper2_2.php",
 				data: "name="+num+" & location="+sta+""
 				/*
 				//返回值
 				 success: function(msg){
  					alert( "Data Saved: " + msg );
 				}
 				*/
			});
		};
	</script>
 </body>
</html>




	
