<?php
/**
 * @desc 提交评论的类,将一维数组 - 评论的内容 - 添加到数据库中。
 * 		 评论内容一定要经过合法检查后，再调用此类。
 */
header('Content-Type:text/html;charset=utf8');

Class PostComment{
	
	private $DB = NULL;
	
	function __construct($Text){
		if(!$this->DB = DB::get_instance()){
//			echo "PostComment.class.php:DataBase Connected Failed~";
			exit();
		}
		if(!$this->DB->select_db()){//选择默认数据库
//			echo "PostComment:select db failed~";
			exit();
		}
	}
	
	function __destruct(){
	
	}
	
	/**
	 * 
	 * 将评论内容插入到数据库
	 */
	public function insert_comment($text = NULL){
		if($text != NULL){
			$sql = "INSERT INTO comment (`article_id`,`name`,`time`,`qq`,`homepage`,`content`)
			VALUES ('$text[article_id]','$text[name]','$text[time]','$text[qq]','$text[homepage]','$text[content]')";
			if(!$this->DB->query($sql)){
				echo "PostComment.class.php:Insert sql failed~";
				exit();
			}else{
//				echo "PostComment:insert ok";
//				echo "Comment Successfully!</br>Turning To Home Page After 3 Seconds...";
//				exit();
//				$this->jump_blog_page();
			}
		}else{
//			echo "PostComment:$text = null";
			exit();
		}
	}
	
	/**
	 * 
	 * 将评论内容插入到数据库
	 */
	public function update_comment($text = NULL){
		if($text != NULL){
			$sql = "UPDATE `comment` SET `name`='$text[name]',`qq`='$text[qq]',`homepage`='$text[homepage]',`content`='$text[content]',`is_show`='$text[is_show]' WHERE id= '$text[id]'";
			if(!$this->DB->query($sql)){
				echo "PostComment.class.php:Update sql failed~";
				exit();
			}else{
//				echo "PostComment:insert ok";
//				echo "Comment Successfully!</br>Turning To Home Page After 3 Seconds...";
//				exit();
//				$this->jump_blog_page();
			}
		}else{
//			echo "PostComment:$text = null";
			exit();
		}
	}
	
}