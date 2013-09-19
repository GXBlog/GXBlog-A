function changeNav(){
	var oDiv = document.getElementById('tagnav_float');
	var oUl = oDiv.getElementsByTagName('ul')[0];	
	var aLi = oUl.getElementsByTagName('li');
	for(var i=0;i<aLi.length;i++){
		aLi.index = i;
		aLi[i].onmouseover = function(){
			this.style.color = "#ffffff";
			this.style.backgroundColor = "#5294DC";
			var BgColorArray = getColorArray(getCurBgColorByObj(this),"#FFFFFF",40);
			var colorArray = getColorArray(getCurColorByObj(this),"#5294DC",40);
			changeBgColor(BgColorArray,this);
			changeColor(colorArray,this);
		}
		
		aLi[i].onmouseout = function(){
			var BgColorArray = getColorArray(getCurBgColorByObj(this),"#5294DC",40);
			var colorArray = getColorArray(getCurColorByObj(this),"#FFFFFF",40);
			changeBgColor(BgColorArray,this);
			changeColor(colorArray,this);
		}
	}
}


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

 function changeTagWall(){
	var oDiv = document.getElementById('tagWall');
	var oUl = oDiv.getElementsByTagName('ul')[0];
	var aLi = oUl.getElementsByTagName('li');
	var i=0;
	
	for(i=0;i<aLi.length;i++){
		aLi[i].index = i;
		aLi[i].style.backgroundColor = getRandomColor();
		aLi[i].onmouseover = function (){
			var BgColorArray = getColorArray(getCurBgColorByObj(this),getRandomColor(),40);
			changeBgColor(BgColorArray,this);
		}
	}
}
