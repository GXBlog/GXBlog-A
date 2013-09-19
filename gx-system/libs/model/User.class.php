<?php
/**
 * 这是一个处理用户操作的类
 * 功能：用户登陆、用户注册、用户注销、用户信息修改等等...
 */

//开启SEESION
session_start();

class User
{
	//声明变量
	private $DB;
	private $TF;
	private $log = false;
	//$DB = new Database();

	/**
	 *
	 * @desc 构造函数，连接数据库、选择数据库
	 * @return BOOLEAN 成功返回TRUE,失败返回FALSE
	 */
	function __construct()
	{
		$this->TF = new TextFilter();
		//链接数据库
		if ( $this->DB = DB::get_instance())
		{
			//选择数据库
			if($this->DB->select_DB())
			{
				return TRUE;
			}
			else return FALSE;
		}
		else return FALSE;

	}

	/**
	 *
	 * @desc 用户类析构函数
	 * @return BOOLEAN true
	 */
	function __destruct()
	{
		return true;
	}

	/**
	 * 执行sql语句
	 * Enter description here ...
	 */
	public function query($query){
		return $this->DB->query($query);
	}



	/**
	 *
	 * @desc 用户登陆的实现
	 * @param $username 用户名
	 * @param $password 密码
	 * @return boolean 登陆成果返回 TRUE 登录失败返回FALSE
	 */
	public function user_log($username,$password)
	{
		$query = "SELECT password FROM user WHERE username = '$username' ";
		$result = $this->DB->query($query);
		while ( $row = mysql_fetch_array($result) )
		{
			if($password == $row['password'])
			{
				$_SESSION['username'] = $username;
				$_SESSION['password'] = $password;
				$this->log = TRUE;
				return TRUE;
			}
			else {
				//				echo "密码错误、登陆失败！";
				return FALSE;
			}
		}
	}

	/**
	 *
	 * @desc 用户注册的实现
	 * @param $username 用户名
	 * @param $password 密码
	 * @param $email 电子邮件
	 * @param $regdate 注册时间
	 * @return BOOLEAN 注册成功返回TRUE 注册失败返回FALSE
	 */
	public function user_reg($username,$password,$email,$regdate)
	{
		$password = md5($password);
		$query = "insert into user (username,password,email,regdate) values ('$username','$password','$email','$regdate')";
		if ( $this->DB->query($query) )
		return TRUE;
		else return FALSE;
	}

	/**
	 *
	 * @desc 用户注销的实现
	 * @param $username
	 * @return BOOLEAN 注销成功返回TRUE、注销失败返回FLASE
	 */
	public function user_logout($username = NULL)
	{
		if( !isset($username) ){
			$username = $this->get_user_name();
		}

		if( $_SESSION['username'] == $username )
		{
			unset($_SESSION['username']);
			unset($_SESSION['password']);
			
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 *
	 * @desc 判断用户是否已经登陆
	 * @return boolean 登陆了返回TRUE，失败了返回FALSE
	 */
	public function is_log()
	{
		if(isset($_SESSION['username']) && isset($_SESSION['password']) )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	
	public function have_log(){
		return $this->log;
	}
	/**
	 *
	 * @desc 返回当前登陆的用户名
	 * @return string/boolean 返回一个字符串信息，即当前登陆的用户名.如果没有用户登陆，则返回FALSE
	 */
	public function get_user_name()
	{
		if($this->is_log())
		{
			return $_SESSION['username'];
		}
		else
		{
			return FALSE;
		}

	}

	/**
	 * 将数组Text中的内容添加到数据库中，发表文章。
	 * Enter description here ...
	 * @param array $Text 表单提交的文章内容
	 * @return boolean 成功返回True，错误返回false
	 * @since 20130309
	 */
	public function create_text(Array $Text){
		$sql ="INSERT INTO article (`title`,`content`,`time`,`tags`,`name`)
		 VALUES ('$Text[title]','$Text[content]','$Text[time]','$Text[tags]','$Text[name]')";

		if ( $this->DB->query($sql) ){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	/**
	 * 取出数据库中文章的内容
	 * @return boolean OR array
	 */
	public function get_text($num=null,$start=null,$require = NULL){
		
		if(!isset($require)) $require = 1;
		
		if(isset($num)){
			if(isset($start)){
				$sql = "SELECT *
				FROM  `article` WHERE ".$require."
				ORDER BY id DESC
				LIMIT ".$start.",".$num;
			}else{
				$sql = "SELECT *
				FROM  `article` WHERE  ".$require."
				ORDER BY id DESC
				LIMIT 0,".$num;
			}

		}else{
			$sql = "SELECT *
				FROM  `article` WHERE ".$require."
				ORDER BY id DESC
				";
		}

		$Text = NULL;

		if($Text = $this->DB->query($sql)){
			return $Text;
		}else {
			return FALSE;
		}
	}

	/**
	 * 
	 * 获取结果集
	 * @param String $table
	 * @param String $field
	 * @param String $query
	 * @param int $num
	 * @param int $start
	 * @param String $order
	 * @param String $desc
	 */
	public function get_result($table = NULL,$field = NULL,
								$require = NULL,$num = NULL,
								$start = NULL,$order = NULL,$desc = NULL){
									
		if(!isset($table)) 		$table = 'article';
		if(!isset($field)) 		$field = '*';
		if(!isset($require)) 	$require = 1;
		if(!isset($num))   		$num   = 100;
		if(!isset($start)) 		$start = 0;
		if(!isset($order)) 		$order = 'id';
		if(!isset($desc)) 		$desc  = 'DESC';
		
		$query = "SELECT ".$field." FROM ".$table." WHERE ".$require." ORDER BY ".$order." ".$desc." LIMIT ".$start." , ".$num;
		
		return $this->DB->query($query);

	}


	/**
	 * 得到最新的文章的id
	 */
	public function get_last_id(){
		$sql = "select * from article order by id desc limit 0,1";
		$result = $this->DB->query($sql);
		while($rows = mysql_fetch_array($result)){
			return $rows['id'];
		}
	}

	/**
	 * 获取特定文章的最新评论的id
	 * $para article_id
	 */
	public function get_last_comment_id($article_id){
		$sql = "select * from comment where article_id = $article_id order by id desc limit 0,1";
		$result = $this->DB->query($sql);
		while($rows = mysql_fetch_array($result)){
			return $rows['id'];
		}
	}

	/**
	 * 得到iSay
	 */
	public function get_iSay(){
		$sql = "select * from iSay order by id desc limit 0,10";
		$result = $this->DB->query($sql);
		return $result;
	}

	/**
	 * 获取num个随机文章结果集
	 * Enter description here ...
	 */
	public function get_recommend_article($num=10){
		$sql = "SELECT * FROM article ORDER BY RAND() LIMIT ".$num;
		$result = $this->DB->query($sql);
		return $result;
	}

	/**
	 * 获取num个最新的心情碎语结果集
	 */
	public function get_moodsay($num=5){
		$sql = "select * from moodsay ORDER BY id DESC LIMIT 10";
		$result = $this->DB->query($sql);
		return $result;
	}

	/**
	 * 获取文章标签
	 * @param $num 正数num个文章里面的标签
	 * @return 返回一维数组
	 */
	public function get_article_tags($num = NULL){
		if($num == NULL){
			$sql = "SELECT tags FROM article";
		}else{
			$sql = "SELECT tags FROM article LIMIT ".$num;
		}

		$result = $this->DB->query($sql);
		$rows = null;
		$tagsArray = array();

		while($rows = mysql_fetch_array($result)){
			$tags = explode(",",$rows['tags']);

			for($i=0;$i<count($tags);$i++){
				if(!in_array($tags[$i],$tagsArray )){
					array_push($tagsArray, $tags[$i]);
				}else{
					//...
				}
			}
		}
		return $tagsArray;
	}

	/**
	 * 获取文章标签
	 * @return 返回一维数组
	 */
	public function get_article_tags_by_id($id = NULL){
		if($id == NULL){
			$sql = "SELECT tags FROM article";
		}else{
			$sql = "SELECT tags FROM article WHERE id = ".$id;
		}

		$result = $this->DB->query($sql);
		$rows = null;
		$tagsArray = array();

		while($rows = mysql_fetch_array($result)){
			$tags = explode(",",$rows['tags']);

			for($i=0;$i<count($tags);$i++){
				if(!in_array($tags[$i],$tagsArray )){
					array_push($tagsArray, $tags[$i]);
				}else{
					//...
				}
			}
		}
		return $tagsArray;
	}

	/**
	 * 获取文章的评论
	 * @param $Num 文章的个数
	 * Enter description here ...
	 */
	public function get_article_comments($num = NULL,$require = NULL){
		
		if(!isset($require)){
			$require = 1;
		}
	
		if($num == NULL){
			$sql = "SELECT * FROM comment WHERE ".$require." ORDER BY id DESC";
		}else{
			$sql = "SELECT * FROM comment WHERE ".$require." ORDER BY id DESC LIMIT ".$num;
		}

		$result = $this->DB->query($sql);

		return $result;

	}
	/**
	 * 获取文章的获准评论
	 * @param $Num 文章的个数
	 * Enter description here ...
	 */
	public function get_article_show_comments($num = NULL){

		if($num == NULL){
			$sql = "SELECT * FROM comment WHERE is_show = 1 ORDER BY id DESC";
		}else{
			$sql = "SELECT * FROM comment WHERE is_show = 1 ORDER BY id DESC LIMIT ".$num;
		}

		$result = $this->DB->query($sql);

		return $result;

	}

	public function get_article_title_by_id($id){
		$sql = "SELECT title FROM article WHERE id = '$id'";
		$result =$this->DB->query($sql);
		if($result){
			$article_title = null;
			$rows = NULL;
			while($rows = mysql_fetch_array($result)){
				$article_title = $rows['title'];
			}
			return $article_title;
		}
	}

	/**
	 * 通过文章id获取文章链接地址
	 * Enter description here ...
	 * @param unknown_type $id
	 */
	public function get_article_link_by_id($id){

		$sql = "select time from article where id = '$id'";

		$result = $this->DB->query($sql);

		$rows = null;
		$link = null;
		while($rows = mysql_fetch_array($result)){
			$link = $rows['time'].".html";
			$link = $this->TF->filter_specific_mark($link," ");//过滤掉指定字符
			$link = $this->TF->filter_specific_mark($link,"-");
			$link = $this->TF->filter_specific_mark($link,":");
			$link = HOME_PATH."static/archives/".$link;
		}
		return $link;

	}

	/**
	 * 通过标签获取文章结果集
	 * Enter description here ...
	 */
	public function get_article_by_tag($tag = NULL){

		if($tag == NULL){
			$sql = "SELECT * FROM article ORDER BY id DESC";
		}else{
			$sql = "SELECT * FROM article WHERE tags LIKE '%$tag%' ORDER BY id DESC";
		}

		$result = NULL;
		$result = $this->DB->query($sql);
		return $result;
	}

	/**
	 * 得到文章的数量
	 * Enter description here ...
	 */
	public function get_article_amount($require = NULL){
		$sql = "select count(*) from article ".$require;
		$result = $this->DB->query($sql);
		$rows = NULL;
		$amount = NULL;
		while($rows = mysql_fetch_array($result)){
			$amount = $rows[0];
		}
		return $amount;
	}

	/**
	 *
	 * 返回数据总数
	 * @param unknown_type $table 表名
	 * @param unknown_type $require 条件
	 */
	public function get_amount($table = NULL,$require = NULL){

		if(!isset($table)) 		$table 		= 'article';
		if(!isset($require)) 	$require 	= 1;

		$sql = "SELECT count(*) FROM ".$table." WHERE ".$require;
		$result = $this->DB->query($sql);
		$rows = NULL;
		$amount = NULL;
		while($rows = mysql_fetch_array($result)){
			$amount = $rows[0];
		}
		return $amount;
	}
	
	public function exits_article($id){
		$sql = "SELECT count(*) FROM article WHERE id = ".$id;
		$result = $this->DB->query($sql);
		$num = null;
		while($rows = mysql_fetch_array($result)){
			$num = $rows[0];
		}
		if($num == 1){
			return TRUE;
		}
		return FALSE;
	}
	
	public function is_untrash_article($id){
		$sql = "SELECT count(*) FROM article WHERE id = ".$id." and trash = 0";
		$result = $this->DB->query($sql);
		$num = null;
		while($rows = mysql_fetch_array($result)){
			$num = $rows[0];
		}
		if($num == 1){
			return TRUE;
		}
		return FALSE;
	}

}