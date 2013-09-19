/** 
 * @Name TagCloud - JS
 * @Author GenialX
 * @QQ 2252065614
 * @URL www.ihuxu.com
 *
 * 调用示例
 *	var oDiv = document.getElementsByTagName('div')[0];
 *	var TG = new TagCloud("oDiv");
 *	TG.start();
 */
 
 /** 
  * @desc 模拟类的入口函数
  * @para tci - tagCloudId
  */
function TagCloud(tci){
	/** 变量声明区 */
	_this = this;//模拟对象指针，并赋予给_this标识符,可以利用该标识符来创建public属性变量和方法
	
	var tagCloudId;//标签云DIV的id
	var oDiv;//标签云的div对象
	var aA;//标签云的a标签对象
	var iTimer = null;//定时器变量
	var divWidth;//div的宽度
	var divHeight;//div的高度
	var aWidth;//a的宽度
	var aHeight;//a的高度
	var aWidthRate = 0.2;//a标签宽度缩放的比例，例如0.2。
	var aHeightRate = 0.2;//a标签高度的缩放比例
	var aLeft;//a（在中点时）与所在的div的左边界的距离 - 即宽度半径
	var aTop;//a（在中点时）与所在的div的上边界的距离 - 即高度半径
	var aCount;//放存a标签的个数
	var aFontSize = 10;//a标签的字体大小
	var aFontSizeRate = 4;//a标签字体大小的缩放范围
	var aZIndex = 1000;//a标签的z-index值
	var aZIndexRate = 1000;//a标签的z-index值得缩放范围
	var angel;//每个a标签所获得的角度
	var radian;//每个a标签所获得的弧度
	var a2r = 2*Math.PI/360;//角度换算成弧度的公式
	var iStep = 0.005;//步长 - 每次增加的弧度
	var stepSum = 0;//步长累计 - 弧度数(不用改动)

	/** 方法声明区 */
	/**
	 * 构造方法
	 */
	var TagCloud = function(){
		tagCloudId = tci;//将标签云DIV的id付给类的私有属性变量
		oDiv = document.getElementById(tagCloudId);
		aA = oDiv.getElementsByTagName('a');
	}
	TagCloud();
	
	/**
	 * 启动方法
	 */
	_this.start=function(){
		iTimer = setInterval(function(){
				//获取div和a标签的高度和宽度
				divWidth = oDiv.offsetWidth;
				divHeight = oDiv.offsetHeight;
				aWidth = aA[0].offsetWidth;
				aHeight = aA[0].offsetHeight;
				//计算圆的宽度半径和高度半径
				aLeft = (divWidth-aWidth)/2;
				aTop = (divHeight-aHeight)/2;
				//获取a标签的个数
				aCount = aA.length;
				//角度
				angel = 360/aCount;
				//弧度
				radian = angel*a2r;
				setInterval(function(){
					//渲染每个a标签
					 render();
				},10);
				clearInterval(iTimer);
				iTimer = null; 
		},10);
	}
	
	/**
	 * @desc 渲染每个a标签 - 设置标签的位置、大小和透明度
	 */
	var render = function(){
		for(var i = 0; i<aCount; i++){//对每一个标签进行处理
			var aItem = aA[i];
			var aRadian = radian*i+stepSum;
			var sinR = Math.sin(aRadian);
			var cosR = Math.cos(aRadian);
			//设置CSS属性
			aItem.style.left = (sinR * aLeft) + aLeft + 'px';
			aItem.style.top = (cosR * aTop) + aTop + 'px';
			aItem.style.fontSize = cosR *aFontSizeRate  + aFontSize + 'px';
			aItem.style.zIndex = cosR*aZIndexRate +aZIndex;
			aItem.style.opacity = (cosR/2.5) + 0.6;
		}
		stepSum += iStep;
	}
}
