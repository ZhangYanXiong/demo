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
	
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/base.css"/>
	<link rel="stylesheet" type="text/css" href="css/index.css"/>

	<script src="bootstrap-3.3.7-dist/js/jquery.js"></script>
	<script src="bootstrap-3.3.7-dist/js/bootstrap.js"></script>

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
			var btn_go=document.getElementById('btn-go');
			btn_go=onclick=function(){

			}
		};
	</script>
    <style type="text/css">
    	
    	.dis-b{
			display: block;
		}
		.dis-n{
			display: none;
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
			<div class="center-block">
				<!-- 介绍 -->
		        <div class="text-center container">
					<h3 class="text-center">我们的团队</h3>
		                <div class="text-center">
		                    <div class="img-circle">
		                        <img src="images/bg.jpg" alt="" class="img-circle img-responsive img-thumbnail" />
		                    </div>
			                <p class="text-primary">
			                    人生需要努力，但也偶尔给自己按下暂停键，走的太多会错失很多风景。慢慢走人生才更有动力，海水味道的空气，和蔼可亲的台腔，吃不完的美食，爱上这座城市啦，这里的美食、美景、美人。此生要来一次台湾！继续攒钱为下一次旅途。 DAY13月4日北京首都国际机场T3航站楼办理登机出境手续后，乘坐八点的国泰航空豪华客机飞往香港转机前往台北桃园机场，抵达后入住桃园酒店！饱岛台湾，夜市琳琅的小吃，香甜可口的水果，丰富可
			                </p>
			                <div class="contact">
			                    <ul class="clearfix">
			                        <li><a href=""><i class="iconfont icon-qq"></i></a></li>
			                        <li><a href=""><i class="iconfont icon-qq"></i></a></li>
			                        <li><a href=""><i class="iconfont icon-qq"></i></a></li>
			                    </ul>
			                </div>
		                </div>
				</div>
   		<!-- 表 -->
				<table class="table table-bordered table-hovered">
					<caption class="text-center">座位</caption>
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
									<div class="col-md-4 col-xs-2">序号</div>
									<div class="col-md-4 col-xs-2">状态</div>									
								</div>
							</th>
							<th>
								<div class="text-center row">
									<div class="col-md-4 col-xs-2">序号</div>
									<div class="col-md-4 col-xs-2">状态</div>								
								</div>
							</th>
							<th>
								<div class="text-center row">
									<div class="col-md-4 col-xs-1">序号</div>
									<div class="col-md-4 col-xs-1">状态</div>									
								</div>
							</th>
							<th>
								<div class="text-center row">
									<div class="col-md-4 col-xs-1">序号</div>
									<div class="col-md-4 col-xs-1">状态</div>
								</div>
							</th>
						</tr>
						<tr class="text-danger">
							<th class="text-danger">
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-4" id="div-con">
										<?php echo $arr[0]; ?>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<button class="btn btn-success btn-xs btnv" id="btn-con"><?php echo $arri[0]; ?></button>
									</div>
								</div>
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-4">		
										<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
									</div>
								</div>
							</th>
							<th class="text-danger">
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-1">					
										<div class="text-center row "><?php echo $arr[1]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-1">
										<div class="text-center row "><button class="btn btn-success btn-xs"><?php echo $arri[1]; ?></button></div>
									</div>
								</div>
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-4">		
										<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
									</div>
								</div>
							</th>
							<th class="text-danger">
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row "><?php echo $arr[2]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row "><button class="btn btn-success btn-xs" id="btnv"><?php echo $arri[2]; ?></button></div>
									</div>
								</div>
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-4">		
										<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
									</div>
								</div>
							</th>
							<th class="text-danger">
								<div class="text-center row ">
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row "><?php echo $arr[3]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
										<div class="text-center row "><button class="btn btn-success btn-xs" id="btnv"><?php echo $arri[3]; ?></button></div>
									</div>
								</div>
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-4">		
										<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
									</div>
								</div>
							</th>
						</tr>
						<tr class="text-danger">
							<th class="text-danger">
								<div class="text-center">
									<div class="text-center col-md-4 col-xs-1">
										<div class="text-center row "><?php echo $arr[4]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-1">
										<div class="text-center row "><button class="btn btn-success btn-xs" id="btnv"><?php echo $arri[4]; ?></button></div>
									</div>
									<div class="text-center col-md-4 col-xs-1">
										<div class="text-center row ">
										<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
										</div>
									</div>
								</div>
							</th>
							<th class="text-danger">
								<div class="text-center row">
									<div class="text-center col-md-4 col-xs-4">					
										<div class="text-center row "><?php echo $arr[5]; ?></div>
									</div>
									<div class="text-center col-md-4 col-xs-4">
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
									<div class="text-center col-md-4 col-xs-4">
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
									<div class="text-center col-md-4 col-xs-4">
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
									<div class="text-center col-md-4 col-xs-4">
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
									<div class="text-center col-md-4 col-xs-4">
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
									<div class="text-center col-md-4 col-xs-4">
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
									<div class="text-center col-md-4 col-xs-4">
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
									<div class="text-center col-md-4 col-xs-4">
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
									<div class="text-center col-md-4 col-xs-4">
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
									<div class="text-center col-md-4 col-xs-4">
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
									<div class="text-center col-md-4 col-xs-4">
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
									<div class="text-center col-md-4 col-xs-4">
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
									<div class="text-center col-md-4 col-xs-4">
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
									<div class="text-center col-md-4 col-xs-4">
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
									<div class="text-center col-md-4 col-xs-4">
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
				<!-- role说明标签的语义 -->
				<div role="dialog" class="modal fade" id="layer">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">确认预约?</h4>
							</div>
							<div class="modal-body text-right">
								<button class="btn btn-primary btn-sm" data-dismiss="modal" >取消</button>
								<!-- data-dismiss="modal" 模态框消失-->
								<button class="btn btn-danger btn-sm" data-dismiss="modal" v-on:click="deleteMsg(nowIndex)" id="btn-go">确定</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div>
				1
			</div>
			<div>
				2
			</div>
			<div>
				3
			</div>
		</div>
	</div>
 </body>
</html>




	
