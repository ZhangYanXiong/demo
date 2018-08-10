/*跨浏览器兼容*/ 
var EventUtil={
	/*添加事件*/ 
	addHandler:function(element,type,handler){
		if(element.addEventListener){
			element.addEventListener(type,handler,false);
		}else if(element.attachEvent){
			element.attachEvent("on"+type,handler);
		}else{
			element["on"+type]=handler;
		}
	},
	/*获取event对象*/ 
	getEvent:function(event){
		return event ? event:window.event;
	},
	/*事件目标*/ 
	getTarget:function(event){
		return event.target||event.srcElement;
	},
	/*取消默认行为*/ 
	preventDefault:function(event){
		if(event.preventDefault){
			event.preventDefault();
		}else{
			event.returnValue=false;
		}
	},
	/*取相关元素*/ 
	getRelatedTarget:function(event){
		if(event.relatedTarget){
			return event.relatedTarget;
		}else if(event.toElement){
			return event.toElement;
		}else if(event.fromElement){
			return event.fromElement;
		}else{
			return null;
		}

	},
	/*鼠标按钮*/ 
	getButton:function(event){
		if(document.implementation.hasFeature("MouseEvents","2.0")){
			return event.button;
		}else{
			switch(event.button){
				case 0:
				case 1:
				case 3:
				case 5:
				case 7:
					return 0;break;
				case 2:
				case 6:
					return 2;break;
				case 4:
					return 1;break;
			}
		}
	},
	/*鼠标滚轮*/
	getWheelDelta:function(event){
		if(event.wheelDelta){
			return (client.engine.opera && client.engine.opera<9.5 ? -event.wheelDelta:event.wheelDelta);
		}else{
			return -event.detail*40;
		}
	},
	/*移除添加的事件*/ 
	removeHandler:function(element,type,handler){
		if(element.removeEventListener){
		element.removeEventListener(type,handler,false);
		}else if(element.detachEvent){
		element.detachEvent("on"+type,handler);
		}else{
		element["on"+type]=null;
		}
	},
	/*取消事件冒泡*/ 
	stopPropagation:function(event){
		if(event.stopPropagation){
			event.stopPropagation();
		}else{
			event.cancelBubble=true;
		}
	}
};