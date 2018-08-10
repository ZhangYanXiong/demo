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
function getLoad(){
	var loadform=document.getElementById("loadform");
	var myFile=loadform[1].files[0];
	var myEmail=loadform[0].value;
	var testEmail=/^\w+@[a-z0-9]+\.[a-z]+$/i;
	if(myEmail!='' && testEmail.test(myEmail)){
		var oFormData = new FormData(); //通过FormData来构建提交数据
    	oFormData.append('file',myFile);
    	oFormData.append('email',myEmail);
		return oFormData;
		
	}else{
		alert("请正确填写邮箱地址!");
		return false;
	}
};
/*ajax函数*/ 
function ajax(url,fnSucc,fnFaild){
	var xhr=createXHR();
	/*进度事件*/ 
	xhr.onload=function(){
		if((xhr.status>=200 && xhr.status<300)||xhr.status==304){
			var txt=JSON.parse(this.responseText);
			alert(txt.msg+':'+txt.url+":"+txt.email);
		}else{
			alert("Request was unseccessful:"+xhr.status);
		}
	};
	xhr.open("post",url,true);
	xhr.setRequestHeader('X-Request-With', 'XMLHttpRequest');
 	oFormData=getLoad();
 	if(oFormData!=false){
 		xhr.send(oFormData); 
 	}else{
 		alert("上传失败！");
 	}
	
};

