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
						// alert(brothers.length);
						/*获取座位号*/ 
						var broN=brothers[0].children;
						var num=broN[0].innerHTML;
						// alert(broN[0].innerHTML);
						
						/*获取状态*/ 
						var brother=brothers[1].children;
						var broS=brother[0].children;
						var sta=broS[0].innerHTML;
						// alert(broS[0].innerHTML);	
						if(sta==1){
							alert("此座位有人，请您重新选择！");
						}else{
							
							changeSql(num,sta);
						}
					};
			}
			/*预约操作*/ 
			
			var btn_go=document.getElementById('btn-go');
			btn_go.onclick=function(ev){
				var oEvent=ev||event;
				// 阻止事件冒泡
				oEvent.cancelBubble=true;
				
			};
		};
		/*
		//获取所有的状态
		 function getStatus(){
			var table_box=document.getElementById('table-box');
			var th_box=table_box.getElementsByTagName('th');
			for(var i=4;i<th_box.length;i++){
				btn=th_box[i].getElementsByTagName('button');
				if(btn[0].innerHTML==1){
					// alert("此座位有人，请您重新选择!"+btn[0].innerHTML);
					// break;
				}else{
					// alert("可以");
				}
			}
		};
		//获取所有的座位号
		function getSeatNumber(){
			var table_box=document.getElementById('table-box');
			var th_box=table_box.getElementsByTagName('th');
			for(var i=4;i<th_box.length;i++){
				div_con=th_box[i].getElementsByTagName('div');
				// alert(div_con[2].innerHTML);
			}
		};*/
		// function submitData(){
		// 	var xhr=createXHR();
		// 	xhr.onreadystatechange=function(){
		// 		if(xhr.readyState==4){
		// 			if((xhr.status>=200 && xhr.status<300)||xhr.status==304){
		// 				alert(xhr.responseText);
		// 			}else{
		// 				alert("Request was unsuccessful:"+xhr.status);
		// 			}
		// 		}
		// 	}
		// };
		function changeSql(num,sta){
			$.ajax({
 				type: "POST",
 				url: "oper2_2.php",
 				data: "name="+num+" & location="+sta+"",
 				success: function(msg){
  					alert( "Data Saved: " + msg );
 				}
			});
			// if(window.XMLHttpRequest){
			// 	var oAjax=new XMLHttpRequest();
			// }else{
			// 	var oAjax=new ActiveXobject("Microsoft.XMLHTTP");
			// }
			// oAjax.open('POST',"oper2_2.php",true);
			// oAjax.send(num,sta);
			// 	oAjax.onreadystatechange=function(){
			// 		if(oAjax.readyState==4){
			// 			if(oAjax.status==200){
			// 				alert("成功！"+oAjax.responseText);
			// 			}else{
			// 				alert("失败！");
			// 			}
			// 		}
			// 	}
		};
	</script>
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
				<table class="table table-bordered table-hovered" id="table-box">
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
											<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#layer" v-on:click="nowIndex=index">预约</button>
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
 </body>
</html>




	
