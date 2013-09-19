/**
 * @Desc 该文件是改变颜色梯度的库 - colorGrad.js
 * @Author GenialX
 * @Date 2013.05.30
 * @QQ 2252065614
 * @URL http://ihuxu.com
 *
 * 调用示例
 *	
 *	var BgColorArray = getColorArray("#5294DC","#FFFFFF",40);
 *	var colorArray = getColorArray("#FFFFFF","#5294DC",40);
 *
 *	var oLi = document.getElementsByTagName('li')[0];
 *
 *	changeBgColor(BgColorArray,oLi);//改变背景颜色
 *	changeColor(colorArray,oLi);//改变背景颜色
 */

/** 
  * 改变颜色的入口函数 
  * beginColor/endColor均为形如#FFFFFF的十六进制的字符串，rate为渐变的速度
  * @return colorArray数组 形如#FFFFFF的字符串数组
  * 调用格式 changeColor("#FFFFFF","#000000",100);
  */
function getColorArray(bColor,eColor,r){
	var curColor = new Object();//过渡中的颜色值，比如#FFFFFF
	var beginColor = new Object();
	var endColor = new Object();
	var rate = new Object();
	var isTrue = new Object();//得到每个rgb增长的方向。true代表增加，false代表减少
	var colorArray = new Array();
	var i = 0;//数组下标

	beginColor = getRGB(bColor);//改变成ogj类型
	endColor = getRGB(eColor);//改变成ogj类型
	curColor = getRGB(bColor);
	rate = getRate(beginColor,endColor,r);
	isTrue = getIsTrue(beginColor,endColor)
	
	while(curColor != false){
		curColor = getCurColor(beginColor,endColor,curColor,rate,isTrue);//得到过渡颜色
		if(curColor != false){//此时将curColor转化为字符串付给数组
			colorArray[i++] = getColor(curColor);
//			alert(colorArray[i-1]);
		}else{
			return colorArray;
		}
	}
}

/** 
  * 将形如#FFFFFFj十六进制的颜色值变为rgb格式
  * color 为形如#FFFFFF的字符串
  * @return obj 为对象
  */
function getRGB(color){
	var obj = new Object();
    obj.r = parseInt(color.substr(1,2), 16);
    obj.g = parseInt(color.substr(3,2), 16);
    obj.b = parseInt(color.substr(5,2), 16);
    
    return obj;
}

/**
  * 得到形如#FFFFFF的颜色值
  * @return 字符串类型
  */
function getColor(curColor){
	var obj = new Object();
	obj.r = Math.round(curColor.r);
    obj.g = Math.round(curColor.g);
    obj.b = Math.round(curColor.b);
    var color = '#';
    color += (obj.r < 16 ? '0':'') + obj.r.toString(16);
    color += (obj.g < 16 ? '0':'') + obj.g.toString(16);
    color += (obj.b < 16 ? '0':'') + obj.b.toString(16);
    
    return color;
}

/**
  * 得到过渡中的颜色
  */
function getCurColor(beginColor,endColor,curColor,rate,isTrue){
	var obj = new Object();
	
	if(Math.abs(curColor.r - endColor.r) >= 1){//未达到标准值
		obj.r = curColor.r;;
		obj.r += isTrue.r?rate.r : -rate.r;
	}else{//颜色接近标准值
		obj.r = endColor.r;
	}
	
	if(Math.abs(curColor.g - endColor.g) >= 1){//未达到标准值
		obj.g = curColor.g;
		obj.g += isTrue.g?rate.g : -rate.g;

	}else{//颜色接近标准值
		obj.g = endColor.g;
	}
	
	if(Math.abs(curColor.b - endColor.b) >= 1){//未达到标准值
		obj.b = curColor.b;;
		obj.b += isTrue.b?rate.b : -rate.b;
	}else{//颜色接近标准值
		obj.b = endColor.b;
		
	}
	
	if(Math.abs(curColor.r - endColor.r) < 1 && Math.abs(curColor.b - endColor.b) < 1 && Math.abs(curColor.g - endColor.g) < 1){//代表所有数字都达到标准值
			return false;
	}
	
	return obj;
}

/** 
  * 得到三种rgb颜色改变的恶速度
  * @return 为object类型
  */
function getRate(beginColor,endColor,rate){
	var obj = new Object();
    obj.r = Math.abs(beginColor.r - endColor.r) / rate;
    obj.g = Math.abs(beginColor.g - endColor.g) / rate;
    obj.b = Math.abs(beginColor.b - endColor.b) / rate;
    
    return obj;
}

function getIsTrue(beginColor,endColor){

	var obj = new Object();
	obj.r =  (beginColor.r - endColor.r) <0 ? true:false; 
	obj.g =  (beginColor.g - endColor.g) <0 ? true:false; 
	obj.b =  (beginColor.b - endColor.b) <0 ? true:false; 
	return obj;
}


/**
  * 得到形如#FFFFFF的颜色值
  * @return 字符串类型 形如#FFFFFF
  */
function getRandomColor(){

	var obj = new Object();

	obj.r = Math.round(Math.random()*255);
    obj.g = Math.round(Math.random()*255);
    obj.b = Math.round(Math.random()*255);
	
    var color = '#';
    color += (obj.r < 16 ? '0':'') + obj.r.toString(16);
    color += (obj.g < 16 ? '0':'') + obj.g.toString(16);
    color += (obj.b < 16 ? '0':'') + obj.b.toString(16);

    return color;
	
}

/**
 * 得到obj对象的背景颜色
 * @return 返回形如#FFFFFF的字符串
 */
function getCurBgColorByObj(obj){
	var color = obj.style.backgroundColor;
	var color1Split = color.split(",");
	var colorObject = new Object();
			
	colorObject.r =parseInt(color1Split[0].substr(4,3));
	colorObject.g = parseInt(color1Split[1]);
	colorObject.b = parseInt(color1Split[2]);
		
	var color = '#';
   	color += (colorObject.r < 16 ? '0':'') + colorObject.r.toString(16);
    color += (colorObject.g < 16 ? '0':'') + colorObject.g.toString(16);
   	color += (colorObject.b < 16 ? '0':'') + colorObject.b.toString(16);

    return color;
}

/**
 * 得到obj对象的颜色
 * @return 返回形如#FFFFFF的字符串
 */
function getCurColorByObj(obj){
	var color = obj.style.color;
	var color1Split = color.split(",");
	var colorObject = new Object();
			
	colorObject.r =parseInt(color1Split[0].substr(4,3));
	colorObject.g = parseInt(color1Split[1]);
	colorObject.b = parseInt(color1Split[2]);
		
	var color = '#';
   	color += (colorObject.r < 16 ? '0':'') + colorObject.r.toString(16);
    color += (colorObject.g < 16 ? '0':'') + colorObject.g.toString(16);
   	color += (colorObject.b < 16 ? '0':'') + colorObject.b.toString(16);

    return color;
}


/**
  * 改变obj的背景颜色的函数
  * @para colorArray 渐变颜色数组 
  *	 	  obj 被改变的对象
  *		  iTm 定时器的唯一标识
  */
function changeBgColor(colorArray,obj){
	
	var i=0;//颜色数组下标
	
	//消除其它定时器在该对象上的作用
	if(typeof(obj.bgColorTimer) == "undefined"){//表示没有绑定在该obj上的定时器
		
	}else{//标定绑定在该obj上的定时器正在运行
		clearInterval(obj.bgColorTimer);
		obj.bgColorTimer = undefined;//销毁定时器
	}
	
	//启动定时器
	obj.bgColorTimer = setInterval(function(){
		if(i < colorArray.length){
			obj.style.backgroundColor = colorArray[i++];
		}else{//停止定时器
			clearInterval(obj.bgColorTimer);
			obj.bgColorTimer = undefined;//销毁定时器
			return;
		}
	},10);
}

/**
  * 改变obj字体颜色的函数
  * @para colorArray 渐变颜色数组 
  *	 	  obj 被改变的对象
  *		  iTm 定时器的唯一标识
  */
function changeColor(colorArray,obj){
	var i=0;//颜色数组下标
	
	//消除其它定时器在该对象上的作用
	if(typeof(obj.colorTimer) == "undefined"){//表示没有绑定在该obj上的定时器
		
	}else{//标定绑定在该obj上的定时器正在运行
		clearInterval(obj.colorTimer);
		obj.colorTimer = undefined;//销毁定时器
	}
	
	//启动定时器
	obj.colorTimer = setInterval(function(){
		if(i < colorArray.length){
			obj.style.color = colorArray[i++];
		}else{//停止定时器
			clearInterval(obj.colorTimer);
			obj.colorTimer = undefined;//销毁定时器
			return;
		}
	},10);
}

/**
  * 改变背景颜色，从当前颜色值渐变到目标颜色值
  * @para endColor 目标颜色值
  *	 	  obj 被改变的对象
  *       iTm 定时器唯一标识
  */
function changeBgColorFromNow(endColor,obj,iTm){
	
}

/**
  * 改变字体颜色，从当前颜色值渐变到目标颜色值
  * @para endColor 目标颜色值
  *	 	  obj 被改变的对象
  *       iTm 定时器唯一标识
  */
function changeColorFromNow(endColor,obj,iTm){
	
}