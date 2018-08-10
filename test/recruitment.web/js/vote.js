/*百分数的转换*/ 
function toPercent(point){
	var str=Number(point*100).toFixed(2);
	str+="%";
	return str;
};
function voteS(str){
	var percent;
	var _data=[],dataData=["环境","待遇","地域","前景"],colors=["#D9544F","#5BB85D","#418BCA","#EFAD4D"];
	var dataDataRet=Object.assign([],dataData).reverse();
	for(let i=0;i<dataData.length;i++){
		_data.push(dataData[i]);
	}
	var data=_data;
	var draw=document.getElementById("drawing");
	if(draw.getContext){
		var context=draw.getContext("2d");
		context.beginPath();
		context.moveTo(0,200);
		context.lineTo(200,200);
		context.moveTo(0,200);
		context.lineTo(0,50);
		context.font="16px,Arial";
		context.textAlign="center";
		context.textBaseline="bottom";
		context.stroke();
		for(let i=0;i<data.length;i++){
			context.fillText(data[i],40*(i+1),220);
		}
		for(var i=0;i<str.length;i++){
			context.fillStyle=colors[i];
			percent=toPercent(str[i]);
			context.fillRect(40*(i+1)-10,(200-str[i]*200),20,(str[i]*200));
			context.fillText(percent,40*(i+1),(200-str[i]*200));
		}
	}
};
