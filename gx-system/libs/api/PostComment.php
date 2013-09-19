<?php
/**
 * 创建评论的接口文件
 * @date 2013.06.01
 * @desc 
 * 1、处理提交的信息、以便判别内容是否合法；
 * 2、将信息格式化成一维数组，传递给PostCommen.class.php文件，将信息插入到数据库；
 * 3、生成静态页面
 * 4、返回innerHTML，通过Ajax技术将信息显示到前台
 */
header('Content-Type:text/html;charset=utf8');

/** 引入相关类文件  */
require_once dirname(dirname(dirname(__FILE__))).'/conf/site.inc.php';
require_once dirname(dirname(__FILE__)).'/model/Db.class.php';
require_once dirname(dirname(__FILE__)).'/model/User.class.php';
require_once dirname(dirname(__FILE__)).'/tools/TextFilter.class.php';
require_once 'PostComment.class.php';


/** 安全处理   */
$User = new User();

if(!isset($_GET['name']) || !isset($_GET['content']) ||
 !isset($_GET['article_id']) || !isset($_GET['action'])){
	echo"PostComment.php:There is no url parameters!";
	exit();
}

/** 获取URL参数  */
$name = $_GET['name'];
$qq = $_GET['qq'];
$homepage = $_GET['homepage'];
$time = date("Y-m-d G:i:s");
$content = $_GET['content'];
$article_id = $_GET['article_id'];
if($User->is_log()){
	if(isset($_GET['is_show'])){
		$is_show = $_GET['is_show'];
	}else{
		$is_show = 0;
	}
}else{
	$is_show = 0;
}

/** 1、判别信息是否合法  */
 $TF = new TextFilter();
 $name = $TF->filter_post_info($name);
 $qq = $TF->filter_post_info($qq);
 $homepage = $TF->filter_post_info($homepage);
 $content = $TF->filter_post_info($content);
 $article_id = $TF->filter_post_info($article_id);
 $is_show = $TF->filter_post_info($is_show);
 

/** 2、对数据格式化为一维数组，并插入数据库  */
$PC = new PostComment();
if($_GET['action'] == "insert"){
	$Text = array("name"=>$name,"time"=>$time,"qq"=>$qq,"homepage"=>$homepage,"article_id"=>$article_id,"content"=>$content,"is_show"=>$is_show);
	$PC->insert_comment($Text);
}else if($_GET['action'] == "update"){
	if($User->is_log()){
		$id = $_GET['id'];
		$Text = array("id"=>$id,"name"=>$name,"qq"=>$qq,"homepage"=>$homepage,"article_id"=>$article_id,"content"=>$content,"is_show"=>$is_show);
		$PC->update_comment($Text);
	}
}


/** 4、返回innerHTML，通过Ajax技术将信息显示到前台  */
echo "yes";
