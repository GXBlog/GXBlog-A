/**
 * @desc 运动框架 - bufferMove
 * @Author GenialX
 * @URL www.ihuxu.com
 * @QQ 2252065614
 * 
 * 调用示例
 * 	var oDiv = document.getElementsByTagName('div')[0];
 * 	bufferMove(oDiv,{width:240,height:300,opacity:100});
 */
function bufferMove(obj, json, fun) {
	clearInterval(obj.timer);
	obj.timer = setInterval(function() {
		var bStop = true;
		for (var attr in json) {
			var iCur = 0;
			if (attr == 'opacity') {
				iCur = parseInt(parseFloat(getStyle(obj, attr)) * 100);
			} else {
				iCur = parseInt(getStyle(obj, attr));
			}
			var iSpeed = (json[attr] - iCur) / 8;
			iSpeed = iSpeed > 0 ? Math.ceil(iSpeed) : Math.floor(iSpeed);

			if (attr == 'opacity') {
				var sum = iCur + iSpeed;
				if(Math.abs(sum - json[attr]) < 10){
					obj.style[attr] = 'alpha(opacity:)' + json[attr] + ')';
					obj.style[attr] = json[attr] / 100;
				}else{
					obj.style[attr] = 'alpha(opacity:)' + (iCur + iSpeed) + ')';
					obj.style[attr] = (iCur + iSpeed) / 100;
				}
			} else {
				obj.style[attr] = iCur + iSpeed + 'px';
			}

			if (iCur != json[attr]) {
				bStop = false;
			}
		}

		if (bStop) {
			clearInterval(obj.timer);
			if (fun) {
				fun();
			}
		}

	}, 10);
}

function getStyle(obj, attr) {
	if (obj.currentStyle) {
		return obj.currentStyle[attr];
	} else {
		return getComputedStyle(obj,false)[attr];
	}
}