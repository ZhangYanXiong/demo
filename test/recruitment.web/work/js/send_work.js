var joffers=document.getElementById('joffers');
var fed=document.getElementById('fed');
var wage=document.getElementById('wage');
var com=document.getElementById('com');
var city=document.getElementById('city');
var exp=document.getElementById('exp');
var edu=document.getElementById('edu');
var timer=document.getElementById('timer');
var arr=new Array(com,fed,wage,com,city,exp,edu,timer);

function insertData(str){
	for(var i=0;i<7;i++){
		arr[i].innerHTML=str[i];
	}
}
function insertAfter(newElement,targetElement,str,workAdd){
	insertData(str);
    var parent = targetElement.parentNode;
    if(parent.lastChild == targetElement){
        parent.appendChild(newElement);
        joffers.firstChild.innerHTML=workAdd;
    }else{
        parent.insertBefore(newElement,targetElement);
        joffers.firstChild.innerHTML=workAdd;
    }
};
function Push(str){
	var workAdd=work.innerHTML;
	var li=document.createElement("li");
	insertAfter(li,joffers.firstChild,str,workAdd);
};