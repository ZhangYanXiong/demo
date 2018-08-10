/*浏览器兼容性处理*/ 
function createXHR(){
	if(typeof  XMLHttpRequest!="undefined"){
		return  new XMLHttpRequest();
	}else if(typeof  ActiveXObject!="undefined"){
		if(typeof arguments.callee.activeXString!="string"){
			var versions=["MSXML2.XMLHttp.6.0","MSXML2.XMLHttp.3.0","MSXML2.XMLHttp"],
						i,len;
			for(i=0,len=versions.length;i<len;i++){
				try{
					new ActiveXObject(versions[i]);
					arguments.callee.activeXString=versions[i];
				 	break;
				}catch(ex){
					//跳过
				}
			}	
		}
		return new ActiveXObject(arguments.callee.activeXString);
	}else{
		throw new Error("No XHR object available");
	}
};
/*获取数据*/ 
function getVote() {
	var radios=document.getElementById('list').vote;
	for(var i=0;i<radios.length;i++){
		if(radios[i].checked){
			return data="vote="+radios[i].value;
		}
	}
};
/*ajax函数*/ 
function ajax(url,fnSucc,fnFaild){
	var xhr=createXHR();
	xhr.onreadystatechange=function(){
		if(xhr.readyState==4){
			if((xhr.status>=200 && xhr.status<300)||xhr.status==304){
				fnSucc(xhr.responseText);
			}else{
				if(fnFaild){
					fnFaild("Request was unseccessful:"+xhr.status);
				}
			}
		}
	};
	var Data=getVote();
	xhr.open("post",url,true);
	xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhr.send(Data); 
};
