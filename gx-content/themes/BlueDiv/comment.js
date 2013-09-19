
/** 操作前台页面 */
function comment_change_html(){
	//声明变量
	var name= "";
	var qq = "";
	var time = "";
	var homepage = "";
	var content = "";
	var div_innerHTML = "";
	var div_desc = "";
	var oBtn = "";
	var oAction = "";
	var xmlhttp;
	//获取表单信息并判断必填项是否为空
	name = document.getElementById('name').value;
	time = get_time();
	oAction = document.getElementById('action').value;
	qq = document.getElementById('qq').value;
	homepage = document.getElementById('homepage').value;
	content = document.getElementById('comment_content').value;
	article_id = document.getElementById('article_id').value;
	div_desc = document.getElementById('desc_div');
	oBtn = document.getElementById('form_button');
	
	if(name == ""){
		alert("姓名不能为空！");
		return;
	}

	if(content == ""){
		alert("评论内容不能为空!");
		return;
	}
	//获取并处理评论显示div的代码段
	div_innerHTML = document.getElementById("comments").innerHTML;
	
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	 	xmlhttp=new XMLHttpRequest();
 	}else{// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
				var innerContent = "<!-- comments-list start --><span id='comments-{comment_id}' class='commenter'>"+name+"</span><i>说: </i></br><i class='commenter_desc'>QQ: </i><span class='commenter_qq'>"+qq+"</span>&nbsp;&nbsp;&nbsp;<i class='commenter_desc'>Site: </i><span class='commenter_homepage'>"+homepage+"</span></br><i class='commenter_desc'>Time: </i><span class='commenter_time'>"+time+"</span></br></br><div class='comments_content'>"+content+"</br><div class='div_reply'>提示：该评论仅暂时可见，请等待GenialX获准，之后方可正常显示。</div></br></div></br><!-- comments-list over -->";
				document.getElementById("comments").innerHTML += innerContent;
				
				/** 清空表单信息 */
				document.getElementById('name').value = "";
				document.getElementById('qq').value = "";
			 	document.getElementById('homepage').value= "";
				document.getElementById('content').value = "";
				
				oBtn.onclick = function(){
					oBtn.onclick = comment_change_html();
				}
				
				div_desc.style.display = "none";
				
    	}else{
			oBtn.onclick = function(){};
			div_desc.style.display = "block";
			
		}
  	}
	

	name_2 = encodeURIComponent(name);
	qq_2 = encodeURIComponent(qq);
	homepage_2 = encodeURIComponent(homepage);
	content_2 = encodeURIComponent(content);
	article_id_2 =  encodeURIComponent(article_id);
	oAction = encodeURIComponent(oAction);
	
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
	oAction = oAction.replace(/>/ig,"&#62;");


	xmlhttp.open("POST",HOME_PATH+"gx-system/libs/api/PostComment.php?name="+name_2+"&qq="+qq_2+"&homepage="+homepage_2+"&content="+content_2+"&article_id="+article_id_2+"&action="+oAction,true);
	xmlhttp.setRequestHeader("context-type","text/html;charset=utf8");
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send();
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

function comment_reply(){
	
}