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
};
function getData(){
	var form=document.getElementById("send");
	var arr=new Array();
	var arr1=new Array("com","addr","pos","expe","edu","wage","sill");
	for(var i=0;i<(form.length-1);i++){
		arr[i]=form[i].value;
	}
	for(var i=0;i<arr.length;i++){
		str=createJson(arr1[i],arr[i]);
	}
	return str;
};
