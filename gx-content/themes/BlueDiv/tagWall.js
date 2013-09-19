/**
 * Copyright www.ihuxu.com
 *
 * @Name: TagWall
 * @Author: GenialX
 */
 
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



