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


/** window.onscroll�¼� */
window.onscroll = function(){
	changeGoTop();
	changeTagnav();
}

/** �õ����ֵ�λ�� */
function getScrollTop(){
	return document.body.scrollTop+document.documentElement.scrollTop;//���IE��Chrome�ļ���������
	
}

/** ���û��ֵ�λ�� */
function setScrollTop(value){
	document.body.scrollTop = value;//Chrome����
	document.documentElement.scrollTop = value;//IE����
}

/** �������Ϲ������ص����� */
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

/** �ⲿ���� */
var step = 0.05;//goTopͼ�꽥��Ĳ���
var target = 0.0;//goTop͸���ȵ�Ŀ��ֵ
var showGoTop = 0;//��ʱ��
var vanishGoTop = 0;//��ʱ��

/**  ��ʾ����ʧgoTopͼ�� */
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

/** �ı�tagnav����λ�� **/
function changeTagnav(){
	//�õ�tagnav�鼶Ԫ��
	var oDiv_nav = document.getElementById("tagnav_float");
	if(getScrollTop() > 120){//��tagnav��position����Ϊfixed
		oDiv_nav.className = "tagnav_float";
	}else if(getScrollTop() < 120){//��tagnav��position���Ի�ԭ
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
