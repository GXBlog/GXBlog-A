<?php
header('Content-Type:text/html;charset=utf-8');

/** 引入相关类文件  */
require_once dirname(dirname(dirname(__FILE__))).'/conf/site.inc.php';
require_once dirname(dirname(__FILE__)).'/model/Db.class.php';
require_once dirname(dirname(__FILE__)).'/tools/TextFilter.class.php';

/** 安全处理   */
$DB = DB::get_instance();
$DB->select_db();
$TF = new TextFilter();

if(!isset($_GET['content']) || !isset($_GET['time'])){
	echo "no";
	exit();
}

$content = $_GET['content'];
$time = date("Y-m-d G:i:s");

//字符过滤
$content = $TF->filter_post_info($content);
//文字长度的处理
if(strlen($content) > 100 ){
	echo "no";
}

//$handle = fopen("iSayTest.txt","w");
//fwrite($handle,$_GET['content'].$_GET['time']);
//fclose($handle);

//数据库请求
$sql = "insert into iSay (content,time) value('$content','$time')";
if($DB->query($sql)){
	echo "yes";
}else{
	echo "no";
}
