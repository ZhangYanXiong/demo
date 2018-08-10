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
var str={};
function createJson(prop, val) {
    // 如果 val 被忽略
    if(typeof val === "undefined") {
        // 删除属性
        delete str[prop];
    }
    else {
        // 添加 或 修改
        str[prop] = val;
    }
    return str;
}
function getData(){
	var form=document.getElementById("send");
	var arr=new Array();
	// var arr1=new Array('"a"','"b"','"c"','"d"','"v"','"r"','"t"');
	for(var i=0;i<(form.length-1);i++){
		arr[i]=form[i].value;
	}
	// var arr2=JSON.stringify(arr);
	// for(var i=0;i<arr.length;i++){
	// 	str=createJson(arr1[i],arr[i]);
	// }
	return {"json": str};
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
	var formData=getData();
	xhr.open("post",url,true);
	xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhr.send(formData); 
};
