
/** window.onscroll事件 */
window.onscroll = function(){
	changeGoTop();
	changeTagnav();
}

/** 得到滑轮的位置 */
function getScrollTop(){
	return document.body.scrollTop+document.documentElement.scrollTop;//解决IE和Chrome的兼容性问题
	
}

/** 设置滑轮的位置 */
function setScrollTop(value){
	document.body.scrollTop = value;//Chrome兼容
	document.documentElement.scrollTop = value;//IE兼容
}

/** 滑轮向上滚动，回到顶部 */
function scrollMove(){
	var goTop=setInterval(function (){
		//alert(getScrollTop());
		if(getScrollTop()>0.5){
			setScrollTop(getScrollTop()/1.1);
			}else {
				document.body.scrollTop = 0;
				document.documentElement.scrollTop = 0;
				clearInterval(goTop);
				}
	},10);
}

/** 外部变量 */
var step = 0.05;//goTop图标渐变的步长
var target = 0.0;//goTop透明度的目标值
var showGoTop = 0;//定时器
var vanishGoTop = 0;//定时器

/**  显示或消失goTop图标 */
function changeGoTop(){
	var	oDiv = document.getElementById("go_top");
	if(getScrollTop()>200 && oDiv.style.opacity < 1 && !showGoTop){
		
		oDiv.style.display = "block";
		clearInterval(vanishGoTop);
		vanishGoTop = 0;
		target = parseFloat(oDiv.style.opacity+"0");
		showGoTop=setInterval(function(){
			oDiv.style.opacity = target;
			target += step;
			if(oDiv.style.opacity > 1){
				oDiv.style.opacity = 1;
				clearInterval(showGoTop);
				showGoTop = 0;
			}
		},30);
	}else if(getScrollTop()<200 && oDiv.style.opacity > 0 && !vanishGoTop){
		clearInterval(showGoTop);
		showGoTop = 0;
		target = parseFloat(oDiv.style.opacity);
		vanishGoTop = setInterval(function (){
				oDiv.style.opacity = target;
				target -= step;
				if(oDiv.style.opacity < 0){
					oDiv.style.opacity = 0;
					clearInterval(vanishGoTop);
					vanishGoTop = 0;
					oDiv.style.display = "none";
				}
			},30);
		}
}

/** 改变tagnav浮动位置 **/
function changeTagnav(){
	//得到tagnav块级元素
	var oDiv_nav = document.getElementById("tagnav_float");
	if(getScrollTop() > 120){//将tagnav的position设置为fixed
		oDiv_nav.className = "tagnav_float";
	}else if(getScrollTop() < 120){//将tagnav的position属性还原
		oDiv_nav.className = "tagnav";
	}
}


/** 该表title文字的效果实现 */
var iTimer_title = [];
function changeTitleToLight(aA,title_id){
	if(!(iTimer_title[title_id] == null)){
		clearInterval(iTimer_title[title_id]);
	}
	
	var iStep = 0.01;//padding增加的步长
	var stepSum = 0;//padding改变的增量值
	var iTarget = 50;//padding增加的目标值
	
	/** 获取渐变颜色数组 */
	var BgColorArray = getColorArray("#DFDFDF","#5294DC",30);
	var colorArray = getColorArray("#5294DC","#FFFFFF",30);

	changeBgColor(BgColorArray,aA);//改变背景颜色
	changeColor(colorArray,aA);//改变背景颜色
	
	
	aA.style.textAlign = "center";
	iTimer_title[title_id] = setInterval(function() {
		stepSum +=(iTarget-stepSum)/8;
	    aA.style.paddingLeft = stepSum + 'px';
	    aA.style.paddingRight = stepSum + 'px';

		if(stepSum >= iTarget-1){
			clearInterval(iTimer_title[title_id]);
			iTimer_title[title_id] = null;
		}
	},10);
}

function changeTitleToDefault(aA,title_id){
	if(!(iTimer_title[title_id] == null)){
		clearInterval(iTimer_title[title_id]);
	}
	var iStep = 0.01;//padding增加的步长
	var stepSum = 50;//padding改变的增量值
	var iTarget = 0;//padding增加的目标值
	
	/** 获取渐变颜色数组 */
	var BgColorArray = getColorArray("#5294DC","#DFDFDF",30);
	var colorArray = getColorArray("#FFFFFF","#5294DC",30);

	changeBgColor(BgColorArray,aA);//改变背景颜色
	changeColor(colorArray,aA);//改变背景颜色
	
	aA.style.textAlign = "left";
	iTimer_title[title_id] = setInterval(function() {
		stepSum -= (stepSum -iTarget)/8;
	    aA.style.paddingLeft = stepSum + 'px';
		aA.style.paddingRight = stepSum + 'px';
		if(stepSum <= iTarget+1){
			clearInterval(iTimer_title[title_id]);
			iTimer_title[title_id] = null;
		}
	},10);
}


/** iSay */
function changeiSay(){
	var oDiv_iSay  = document.getElementById('iSay');
	var oDiv_close = oDiv_iSay.getElementsByTagName('div')[0];
	var oDiv_top = oDiv_iSay.getElementsByTagName('div')[1];
	var oDiv_btn = oDiv_iSay.getElementsByTagName('div')[2];
	var oDiv_center = oDiv_iSay.getElementsByTagName('div')[3];
	var oText = oDiv_top.getElementsByTagName('textarea')[0];
	
	var GCDM = new gcdMove(oDiv_iSay,5,0);
	
	oDiv_iSay.iTimer = null;
	GCDM.startMove();
	
	oDiv_iSay.onmouseover = function(){
		GCDM.startMove();
		bufferMove(oDiv_iSay,{width:240,height:420});
		bufferMove(oDiv_top,{width:240,height:60,opacity:100});
		bufferMove(oDiv_btn,{width:60,height:20,opacity:100});
		bufferMove(oDiv_center,{width:240,height:300,opacity:100});
	}
	
	 oDiv_close.onmousedown = function(){
		GCDM.stopMove();
		bufferMove(oDiv_iSay,{width:110,height:18,left:0,top:120});
		bufferMove(oDiv_top,{width:0,height:0,opacity:0});
		bufferMove(oDiv_btn,{width:0,height:0,opacity:0});
		bufferMove(oDiv_center,{width:0,height:0,opacity:0});
	}
	
	oDiv_top.onmousedown = oDiv_center.onmousedown = function(){
		GCDM.stopMove();
	}
	
	oDiv_btn.onmousedown = function(){
		GCDM.stopMove();
		var textValue = "";
		if(oText.value == ""){
			return;
		}else{
			textValue = oText.value;
			textValue = textValue.replace(/</ig,"&#60;");
			textValue = textValue.replace(/>/ig,"&#62;");
		}
		
		if( textValue.length > 50 ){
			alert("文字太长！");
			return;
		}

		var oDiv_item = document.createElement('div');
		var aDiv_item = oDiv_center.getElementsByTagName('div');
		var time = get_time();
		var content = oText.value;
		oDiv_item.innerHTML = "<div class='item'>"+textValue+"</div><div class='time'><div class='time_right'>"+time+"</div></div>";
		oText.value = "";
		
		//AJAX
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	 	xmlhttp=new XMLHttpRequest();
 	}else{// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
		
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
				
		if(aDiv_item.length){
			oDiv_center.insertBefore(oDiv_item,aDiv_item[0]);
		}else {
			 oDiv_center.appendChild(oDiv_item);
		}
		
		var iHeight = oDiv_item.offsetHeight;
		oDiv_item.style.height = 0;
		oDiv_item.style.opacity=0;
		bufferMove(oDiv_item,{height:iHeight,opacity:100});
		
    	}else{
			//提示等待信息
		}
  	}
	content = encodeURIComponent(content);
	time = encodeURIComponent(time);
	
	xmlhttp.open("GET",HOME_PATH+"gx-system/libs/api/PostiSay.php?content="+content+"&time="+time,true);
	xmlhttp.setRequestHeader("context-type","text/html;charset=utf-8");
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send();
	}
}

function get_time(){
	var time = "";
	var date = new Date();
	time = date.getFullYear()+"-"; //读英文就行了
	time = time + (date.getMonth()+1)+"-";//取月的时候取的是当前月-1如果想取当前月+1就可以了
	time = time + date.getDate()+" ";
	time = time + date.getHours()+":";
	time = time + date.getMinutes()+":";
	time = time + date.getSeconds()+"";
	return time;
}


/** 导航栏 */

function lightNavItem(i){
	
	/** 获取对象 */
	var oDiv = document.getElementById('tagnav_float');
	var oUl = oDiv.getElementsByTagName('ul')[0];
	var oLi = oUl.getElementsByTagName('li')[i];
	
	/** 获取渐变颜色数组 */
	oLi.style.backgroundColor = "#5294DC";
	oLi.style.color = "#FFFFFF";
	var BgColorArray = getColorArray(getCurBgColorByObj(oLi),"#FFFFFF",30);
	var colorArray = getColorArray(getCurColorByObj(oLi),"#5294DC",30);
	
	changeBgColor(BgColorArray,oLi);//改变背景颜色
	changeColor(colorArray,oLi);//改变背景颜色
	
}


function recoverNavItem(i){
	
	/** 获取对象 */
	var oDiv = document.getElementById('tagnav_float');
	var oUl = oDiv.getElementsByTagName('ul')[0];
	var oLi = oUl.getElementsByTagName('li')[i];
	
	/** 获取渐变颜色数组 */
	var BgColorArray = getColorArray(getCurBgColorByObj(oLi),"#5294DC",40);
	var colorArray = getColorArray(getCurColorByObj(oLi),"#FFFFFF",40);
	
	changeBgColor(BgColorArray,oLi);//改变背景颜色
	changeColor(colorArray,oLi);//改变背景颜色
}
