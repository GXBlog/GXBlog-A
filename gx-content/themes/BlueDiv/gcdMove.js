/**
 * @Desc 重力碰撞拖拽运动 - Gravity Crash Drag Move(gcdMove)
 * @Author GenialX
 * @URL www.ihuxu.com
 * @QQ 2252065614
 * @Date 2013.06.22
 * 
 * 调用示例
 *	var oDiv = document.getElementsByTagName('div')[0];
 * 	var GCDM = new gcdMove(oDiv,0,0);
 *	GCDM.startMove();
 */

/**
 * @param iSpeedX/iSpeedY 是初始化的横向和纵向的速度
 */
function gcdMove(obj, iSpeedX, iSpeedY) {

	_this = this;//public identifier

	//construct fun
	var gcdMove;
	//self defined fun
	var start;
	_this.startMove;
	//other var
	var iTimer;
	var iLastX = 0;
	var iLastY = 0;

	//construct fun
	start = function() {
		clearInterval(iTimer);

		iTimer = setInterval(function() {

			iSpeedY += 3;

			var l = obj.offsetLeft + iSpeedX;
			var t = obj.offsetTop + iSpeedY;

			if (t >= document.documentElement.clientHeight - obj.offsetHeight) {
				iSpeedY *= -0.8;
				iSpeedX *= 0.8;
				t = document.documentElement.clientHeight - obj.offsetHeight;
			} else if (t <= 0) {
				iSpeedY *= -1;
				iSpeedX *= 0.8;
				t = 0;
			}

			if (l >= document.documentElement.clientWidth - obj.offsetWidth) {
				iSpeedX *= -0.8;
				l = document.documentElement.clientWidth - obj.offsetWidth;
			} else if (l <= 0) {
				iSpeedX *= -0.8;
				l = 0;
			}

			if (Math.abs(iSpeedX) < 1) {
				iSpeedX = 0;
			}

			if (iSpeedX == 0 && iSpeedY == 0 && t == document.documentElement.clientHeight - obj.offsetHeight) {
				clearInterval(iTimer);
			}

			obj.style.left = l + 'px';
			obj.style.top = t + 'px';

		}, 30);
	}
	
	_this.startMove = function(){
			obj.onmousedown = function(ev) {

		clearInterval(iTimer);

		var oEvent = ev || event;

		var disX = oEvent.clientX - obj.offsetLeft;
		var disY = oEvent.clientY - obj.offsetTop;

		document.onmousemove = function(ev) {
			var oEvent = ev || event;

			var l = oEvent.clientX - disX;
			var t = oEvent.clientY - disY;

			obj.style.left = l + 'px';
			obj.style.top = t + 'px';

			if(iLastX ==0){
				iLastX = l;
			}
			if(iLastY == 0){
				iLastY = t;
			}
			iSpeedX = l - iLastX;
			iSpeedY = t - iLastY;

			iLastX = l;
			iLastY = t;

		}
	}

	obj.onmouseup = function() {
		document.onmousedown = null;
		document.onmousemove = null;
		document.onmouseup = null;
		start();
	}
		start();
	}
	
	_this.stopMove = function(){
		clearInterval(iTimer);
		obj.onmousedown = null;
		document.onmousemove = null;
		obj.onmouseup = null;
		iLastX = 0;
		iLastY = 0;
		iSpeedX = 0;
		iSpeedY = 0;
		disX = 0;
		disY = 0;
	}
	
	//CONSTRUCT AREA
	var gcdMove = function() {

		if (!iSpeedX) {
			iSpeedX = 0;
		}
		if (!iSpeedY) {
			iSpeedY = 0;
		}
	}
	
	gcdMove();
}

