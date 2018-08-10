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
/*获取表单数据*/ 
function getLogin(){
	var form=document.getElementById("user-info");
	if(form[0].value==""&&form[1].value==""){
		alert("账号和密码不能为空，请输入完整的数据！");
		return false;
	}else{
		var formData="userid="+form[0].value+"&password="+form[1].value;
		return formData;
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
	var formData=getLogin();
	if(formData==false){
		xhr.abort();
	}else{
		xhr.open("post",url,true);
		xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		xhr.send(formData); 
	}
};
