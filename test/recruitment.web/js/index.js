/*轮播图*/ 
window.onload=function(){
    		var speed=2;
    		var timer=null;
    		var ner=document.getElementById('ner');
    		var oLi=ner.getElementsByTagName('li');
    		var oUl=ner.getElementsByTagName('ul')[0];
    		var btn=ner.getElementsByTagName('div');
    		oUl.innerHTML=oUl.innerHTML+oUl.innerHTML;
    		oUl.style.width=oLi[0].offsetWidth*oLi.length+"px";
    		function bannerFun(){
    			if(oUl.offsetLeft<-oUl.offsetWidth/2){
    				oUl.style.left='0';
    			}
    			if(oUl.offsetLeft>=0){
    				oUl.style.left=-oUl.offsetWidth/2+'px';
    			}
    			oUl.style.left=oUl.offsetLeft+speed+'px';	
    		};
    		timer=setInterval(bannerFun,100);
            btn[0].onclick=function(){
                speed=-2;
            };
            btn[1].onclick=function(){
                speed=2;
            };
            btn[2].onmouseover=function(){
                clearInterval(timer);
            };
            btn[2].onmouseout=function(){
                timer=setInterval(bannerFun,100);
            };
    	};
/*选项卡*/ 
       $(function(){
          $(".dropdown-toggle").dropdown('toggle');
          }); 
