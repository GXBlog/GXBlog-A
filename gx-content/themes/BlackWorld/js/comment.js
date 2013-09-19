function comment(){
	HOME_PATH = 'http://localhost/gxblog/';
	//声明变量
	var name= "";
	var qq = "";
	var time = "";
	var homepage = "";
	var content = "";
	var article_id = "";
	var oBtn;
	var action = "";
	var xmlhttp;
	
	//获取内容
	name 		= document.getElementById('comment_name').value;
	qq 			= document.getElementById('comment_qq').value;
	time 		= get_time();
	homepage 	= document.getElementById('comment_homepage').value;
	content 	= document.getElementById('comment_content').value;
	action 		= document.getElementById('comment_action').value;
	article_id	= document.getElementById('article_id').value;
	oBtn 		= document.getElementById('comment_button');
	
	//过滤内容
	if(name == ""){
		alert("姓名不能为空！");
		return;
	}

	if(content == ""){
		alert("评论内容不能为空!");
		return;
	}
	
	name_2 = encodeURIComponent(name);
	qq_2 = encodeURIComponent(qq);
	homepage_2 = encodeURIComponent(homepage);
	content_2 = encodeURIComponent(content);
	article_id_2 =  encodeURIComponent(article_id);
	action_2 = encodeURIComponent(action);
	
	name = name.replace(/</ig,"&#60;");
	name = name.replace(/>/ig,"&#62;");	
	qq = qq.replace(/</ig,"&#60;");
	qq = qq.replace(/>/ig,"&#62;");
	homepage = homepage.replace(/</ig,"&#60;");
	homepage = homepage.replace(/>/ig,"&#62;");
	content = content.replace(/</ig,"&#60;");
	content = content.replace(/>/ig,"&#62;");
	article_id = article_id.replace(/</ig,"&#60;");
	article_id = article_id.replace(/>/ig,"&#62;");
	action = action.replace(/>/ig,"&#62;");
	
	//提交内容
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	 	xmlhttp=new XMLHttpRequest();
 	}else{// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			alert('提交成功，请等待站长获准！');
			document.getElementById('comment_name').value = "";
			document.getElementById('comment_qq').value = "";
			document.getElementById('comment_homepage').value = "";
			document.getElementById('comment_content').value = "";
			oBtn.value = '提交';
			
    	}else{
    		oBtn.value = '提交中..'
		}
  	}
	
	xmlhttp.open("POST",HOME_PATH+"gx-system/libs/api/PostComment.php?name="+name_2+"&qq="+qq_2+"&homepage="+homepage_2+"&content="+content_2+"&article_id="+article_id_2+"&action="+action_2,true);
	xmlhttp.setRequestHeader("context-type","text/html;charset=utf8");
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send();
	
	return;
}

/** 得到当前时间 */
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
