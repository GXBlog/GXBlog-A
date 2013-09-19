<?php
/**
 * 后台过程控制器
 * 
 */

Class AdminAction implements Admin{

	private $User 			= NULL;
	private $GXE			= NULL;
	private $STA			= NULL;
	private $TF				= NULL;
	private $action			= NULL;

	public function __construct($GXE){
		$this->User			= new User();
		$this->GXE			= $GXE;
		$this->TF			= new TextFilter();
		if(class_exists('TemplateAction')){
			$this->STA			= new TemplateAction();	
		}else{
			$this->STA			= new GenerateHtml();
		}

	}
	public function show_index(){

		$this->action = $this->get_param("action");

		switch($this->action){
			case '':
				if(!$this->is_log()){
					$this->GXE->dispose_filename('login.html');
					$this->GXE->assign('site_path',HOME_PATH);
					$this->GXE->assign('error_show','none');
					$this->GXE->display();
				}else{
					$this->GXE->dispose_filename('index.html');
					$this->GXE->assign('home_path',HOME_PATH);
					$this->GXE->require_file("filename","admin_index.html");
					$this->GXE->display();
				}
				;break;
			case 'login':
				$uname		= $_POST['uname'];
				$pwd		= $_POST['pwd'];
				if($this->User->user_log($uname,$pwd)){
					$this->GXE->dispose_filename('index.html');
					$this->GXE->assign('home_path',HOME_PATH);
					$this->GXE->require_file("filename","admin_index.html");
					$this->GXE->display();
				}else{
					$this->GXE->assign('site_path',HOME_PATH);
					$this->GXE->assign('error_show','block');
					$this->GXE->dispose_filename('login.html');
					$this->GXE->display();
				}
				;break;
			case 'article':
				$this->is_admin();
					
				$type = $this->get_param("type");

				$this->GXE->dispose_filename('index.html');
				$this->GXE->assign("home_path",HOME_PATH);

				switch ($type){
					case '':
						$this->GXE->require_file("filename","article_index.html");
						;break;
					case 'write':
						$this->GXE->require_file("filename","article_write.html");
						$this->GXE->assign('message_show','none');
						;break;
					case 'post':
						$this->GXE->require_file("filename","article_write.html");
						$this->post_article();
						;break;
					case 'edit':
						$this->GXE->require_file("filename","article_edit.html");
						$this->dispose_article_edit();
						;break;
					case 'manager':
						$this->GXE->require_file("filename","article_manager.html");
						$this->dispose_article_list();
						;break;
					case 'trash':
						$this->GXE->require_file("filename","article_trash.html");
						$this->dispose_article_list("trash = 1 ");
						;break;
					case 'untrash':
						$this->GXE->require_file("filename","article_untrash.html");
						$this->dispose_article_list("trash = 0 ");
						;break;
					default:
						$this->GXE->require_file("filename","article_index.html");
						;break;
				}

				$this->GXE->display();
				;break;
			case 'comment':
				$this->is_admin();

				$type = $this->get_param('type');

				$this->GXE->dispose_filename('index.html');
				$this->GXE->assign("home_path",HOME_PATH);

				switch ($type){
					case '':
						$this->GXE->require_file('filename','comment_index.html');
						;break;
					case 'manager':
						$this->GXE->require_file('filename','comment_manager.html');
						$this->dispose_comment_list();
						;break;
					case 'unpermit':
						$this->GXE->require_file('filename','comment_unpermit.html');
						$this->dispose_comment_list(" is_show = 0 ");
						;break;						
					case 'permit':
						$this->GXE->require_file('filename','comment_permit.html');
						$this->dispose_comment_list(" is_show = 1 ");
						;break;							
					case 'forbid':
						$this->GXE->require_file('filename','comment_forbid.html');
						$this->dispose_comment_list(" is_show = 2 ");
						;break;					
					case 'untrash':
						$this->GXE->require_file('filename','comment_untrash.html');
						$this->dispose_comment_list(" trash = 0 ");
						;break;							
					case 'trash':
						$this->GXE->require_file('filename','comment_trash.html');
						$this->dispose_comment_list(" trash = 1 ");
						;break;					
					case 'edit':
						$this->GXE->require_file('filename','comment_edit.html');
						$this->dispose_comment_edit();
						;break;
					default:
						$this->GXE->require_file('filename','comment_index.html');
						;break;
				}

				$this->GXE->display();

				;break;
			case 'moodsay':
				$this->is_admin();

				$type = $this->get_param('type');

				$this->GXE->dispose_filename('index.html');
				$this->GXE->require_file('filename','moodsay_index.html');
				$this->GXE->assign("home_path",HOME_PATH);
				
				$this->GXE->display();
				
				;break;
			case 'theme':
				$this->is_admin();

				$type = $this->get_param('type');

				$this->GXE->dispose_filename('index.html');
				$this->GXE->assign("home_path",HOME_PATH);
				
				switch ($type){
					case '':
						$this->GXE->require_file('filename','theme_index.html');
						$this->dispose_theme_show();
						;break;
					case 'show':
						$this->GXE->require_file('filename','theme_index.html');
						$this->dispose_theme_show();
						;break;
					case 'post':
						$this->GXE->require_file('filename','theme_index.html');
						$this->dispose_theme_post();
						;break;
					default:
						$this->GXE->require_file('filename','theme_index.html');
						$this->dispose_theme_show();
						;break;
				}
				
				$this->GXE->display();
				;break;
			default:
				$this->GXE->dispose_filename('login.html');
				$this->GXE->assign('site_path',HOME_PATH);
				$this->GXE->assign('error_show','none');
				$this->GXE->display();
				;break;
		}
	}

	/**
	 * 判断是否有操作权限
	 */
	private function is_admin(){
		if($this->User->is_log()){
			return TRUE;
		}else{
			echo "Alert: You Have Not This RiSTAt!";
			exit();
		}
	}

	/**
	 * 判断是否登录过
	 */
	private function is_log(){
		return $this->User->is_log();
	}

	/**
	 * 发表文章
	 */
	private function post_article(){
		$Text = NULL;
		$title = $_POST['title'];
		$content = $_POST['content'];
		$name = 'Author';
		$content = $this->TF->filter_article_content_post($content);
		$time = date("Y-m-d G:i:s"); // Format: 2013-03-10 12:17:24
		$tags = $_POST['tags'];
		$Text = array("title"=>$title,"content"=>$content,"time"=>$time,"tags"=>$tags,"name"=>$name);
		if($this->User->create_text( $Text)){
			$article_last_id = $this->User->get_last_id();

			$this->STA->generate_archive($article_last_id);
			$this->GXE->assign('message_show','block');
			$this->GXE->assign('message_show_content','文章已发布。');
			return TRUE;
		}else {
			return FALSE;
		}
	}

	/**
	 * 获取参数
	 * @param unknown_type $name
	 */
	private function get_param($name){
		if (isset($_GET[$name])){
			return $_GET[$name];
		}else if(isset($_POST[$name])){
			return  $_POST[$name];
		}else{
			return '';
		}
	}

	/**
	 * 获取do_array
	 * @param unknown_type $do_array
	 */
	private function get_do_array($do_array){
		if($do_array == '') return '';
		return explode(",", $do_array);
	}

	/**
	 * 操作文章
	 */
	private function do_article($do,$do_array){
		
		if($do_array == '') return;

		$query		= $this->get_sql($do_array);
		$sql 		= NULL;

		switch ($do){
			case 'delete':
				$sql = "DELETE FROM article WHERE ".$query;
				$this->User->query($sql);
				$query = $this->get_sql($do_array,'article_id');
				$sql = "DELETE FROM comment WHERE  ".$query;
				$this->User->query($sql);
				;break;
			case 'trash':
				$sql = "UPDATE article SET trash = 1 WHERE ".$query;
				$this->User->query($sql);
				$query = $this->get_sql($do_array,'article_id');
				$sql = "UPDATE comment SET trash = 1 WHERE ".$query;
				$this->User->query($sql);
				;break;
			case 'untrash':
				$sql = "UPDATE article SET trash = 0 WHERE ".$query;
				$this->User->query($sql);
				$query = $this->get_sql($do_array,'article_id');
				$sql = "UPDATE comment SET trash = 0 WHERE ".$query;
				$this->User->query($sql);
				;break;
			default:;break;
		}

	}

	/**
	 * 获取sql的WHERE部分
	 * @param unknown_type $do_array
	 */
	private function get_sql($do_array,$field = NULL){
		$query 		= '';
		$do_id		= NULL;

		if(!isset($field)){
			$field = 'id';
		}
		
		while($do_id = array_pop($do_array)){
			if($query == ''){
				$query = ' '.$field.' = '.$do_id;
			}else{
				$query .= ' or '.$field.' = '.$do_id;
			}
		}
		return $query;
	}

	/**
	 * 获取manager_article_list
	 */
	private function get_article_list($page,$require = NULL){
		$Text 			= NULL;
		$link 			= NULL;
		$articles 		= NULL;

		if($page == ''){
			$page = 1;
		}

		$page_nums = $this->get_page_nums('article',$require);

		if($page > $page_nums){
			$page = $page_nums;
		}

		if($Text = $this->User->get_text(AdminAction::PAGE_NUM,AdminAction::PAGE_NUM*
										$page-AdminAction::PAGE_NUM,$require)){
			$rows = NULL;

			while($rows = mysql_fetch_array($Text)){
				$tags = array();
				$link = $rows['time'].".html";
				$link = $this->TF->filter_specific_mark($link," ");//过滤掉指定字符
				$link = $this->TF->filter_specific_mark($link,"-");
				$link = $this->TF->filter_specific_mark($link,":");
				$link = HOME_PATH."static/archives/".$link;
				$rows['content'] = $this->TF->get_article_abstract($rows['content']);
				$rows['content'] = str_replace(chr(13), "</br>", $rows['content']);
				//标签的处理
				$tagsArray = explode(",",$rows['tags']);
				for($i=0;$i<count($tagsArray);$i++){
					array_push($tags,$tagsArray[$i]);
				}
				$articles[] = array("id"=>$rows['id'],"title"=>$rows['title'],
									"name"=>$rows['name'],"time"=>$rows['time'],"comment"=>$rows['comment'],
									"tags"=>$tags,"link"=>$link);
			}
		}

		if(is_array($articles)){
			return $articles;
		}else{
			return FALSE;
		}
	}

	/**
	 * 得到指定文章的数量
	 * @param unknown_type $require
	 */
	private function get_article_nums($require = NULL){
		return $this->User->get_amount('article',$require);
	}

	/**
	 * 得到分页数组
	 * @param unknown_type $page
	 */
	private function get_page_array($page = NULL,$table = NULL,$require = NULL){

		/** 分页处理 */
		$page_nums = null;//共计页数
		$page_array = null;

		if($page == ''){
			$page = 1;
		}

		$page_nums = $this->get_page_nums($table,$require);
		if($page <= $page_nums){
			for($i = 0;$i<$page_nums;$i++){
				$selected = (($i+1) == $page)?'selected':'';
				$page_array[$i] = array("page"=>($i+1),"selected"=>$selected);
			}
		}else{
			for($i = 0;$i<$page_nums;$i++){
				$selected = (($i+1) == $page_nums)?'selected':'';
				$page_array[$i] = array("page"=>($i+1),"selected"=>$selected);
			}
		}

		return $page_array;
	}

	/**
	 * 得到页数共计
	 */
	private function get_page_nums($table = NULL,$require = NULL){
		return ceil(($this->User->get_amount($table,$require)+0.0)/AdminAction::PAGE_NUM);
	}

	/**
	 * 获取非回收站文章数量
	 */
	private function get_untrash_article_nums(){
		return $this->User->get_amount('article','trash = 0');
	}

	/**
	 * 获取回收站文章数量
	 */
	private function get_trash_article_nums(){
		return $this->User->get_amount('article','trash = 1');
	}

	/**
	 * 文章管理页面的公共处理代码段
	 */
	private function dispose_article_list($require = NULL){
		$page 			= $this->get_param("page");
		$do	 			= $this->get_param("do");
		$do_array		= $this->get_do_array($this->get_param("do_array"));

		switch ($do){
			case '':;break;
			case 'delete':
				$this->do_article($do, $do_array);
				;break;
			case 'trash':
				$this->do_article($do, $do_array);
				;break;
			case 'untrash':
				$this->do_article($do, $do_array);
				;break;
			default:;break;
		}

		//获取解释器信息
		/** 单变量信息 */
		$this->GXE->assign('all_article_nums',$this->get_article_nums());
		$this->GXE->assign('untrash_article_nums',$this->get_untrash_article_nums());
		$this->GXE->assign('trash_article_nums',$this->get_trash_article_nums());
		/** 分页信息 */
		$pages = $this->get_page_array($page,'article',$require);

		if($pages){
			$this->GXE->assign('pages',$pages);
		}else{
			$this->GXE->del_section('pages');
		}

		$this->GXE->assign('page_nums',$this->get_page_nums('article',$require));

		/** 文章列表信息 */
		$articles = $this->get_article_list($page,$require);

		if($articles){
			$this->GXE->assign('articles',$articles,3);
		}else{
			$this->GXE->del_section('articles');
		}
	}

	/**
	 * 编辑文章的代码段
	 */
	private function dispose_article_edit(){
		$do = $this->get_param('do');
		switch($do){
			case '':;break;
			case 'show':
				$do_array = $this->get_do_array($this->get_param('do_array'));
				$do_id = $do_array[0];

				$text = $this->User->get_text(null,null,'id = '.$do_id);

				$rows = null;

				while($rows = mysql_fetch_array($text)){
					$this->GXE->assign('article_title',$rows['title']);
					$this->GXE->assign('article_tags',$rows['tags']);
					$this->GXE->assign('article_content',$rows['content']);
					$this->GXE->assign('article_id',$rows['id']);
					break;
				}

				$this->GXE->assign('message_show','none');
					
				;break;
			case 'post':
				$do_array = $this->get_do_array($this->get_param('do_array'));
				$do_id = $do_array[0];

				$title = $this->get_param('title');
				$tags = $this->get_param('tags');
				$content = $this->get_param('content');
				$content = $this->TF->filter_article_content_post($content);

				$sql = "UPDATE article set title = '".$title."', tags = '".$tags."', content = '".
				$content."' WHERE id = ".$do_id;

				$this->User->query($sql);

				$this->STA->generate_archive($do_id);

				$this->GXE->assign('article_title',$title);
				$this->GXE->assign('article_tags',$tags);
				$this->GXE->assign('article_content',$content);
				$this->GXE->assign('article_id',$do_id);

				$this->GXE->assign('message_show','block');
				$this->GXE->assign('message_show_content','文章已编辑。');
					
				;break;
			default:;break;
		}
	}

	private function do_comment($do,$do_array){

		if($do_array == '') return;
		
		$query		= $this->get_sql($do_array);
		
		$sql 		= NULL;

		switch ($do){
			case 'delete':
				$sql = "DELETE FROM comment WHERE ".$query;
				
				$require_comment  	= $this->get_sql($do_array);
				$result = $this->User->get_result('comment','article_id',$require_comment);
				$article_id_array = array();
				while($rows = mysql_fetch_array($result)){
					$article_id_array[] = $rows['article_id'];
				}
				
				$this->User->query($sql);
				
				//更新文章页
				foreach ($article_id_array as $value){
					$this->STA->generate_archive($value);
				}
				return;
				;break;
			case 'permit':
				$sql = "UPDATE comment SET is_show = 1 WHERE ".$query;
				;break;
			case 'unpermit':
				$sql = "UPDATE comment SET is_show = 0 WHERE ".$query;
				;break;
			case 'forbid':
				$sql = "UPDATE comment SET is_show = 2 WHERE ".$query;
				;break;
			case 'trash':
				$sql = "UPDATE comment SET trash = 1 WHERE ".$query;
				;break;
			case 'untrash':
				$sql = "UPDATE comment SET trash = 0 WHERE ".$query;
				;break;
			default:;break;
		}
		
		
		$this->User->query($sql);
				
		$require_comment  	= $this->get_sql($do_array);
		$result = $this->User->get_result('comment','article_id',$require_comment);
		$article_id_array = array();
		while($rows = mysql_fetch_array($result)){
			$article_id_array[] = $rows['article_id'];
		}
		
		//更新文章页
		foreach ($article_id_array as $value){
			$this->STA->generate_archive($value);
		}
	}

	private function get_comment_nums(){
		return $this->User->get_amount('comment');
	}

	private function get_unpermit_comment_nums(){
		return $this->User->get_amount('comment','is_show = 0');
	}

	private function get_permit_comment_nums(){
		return $this->User->get_amount('comment','is_show = 1');
	}

	private function get_forbid_comment_nums(){
		return $this->User->get_amount('comment','is_show = 2');
	}
	
	private function get_untrash_comment_nums(){
		return $this->User->get_amount('comment',' trash = 0 ');
	}

	private function get_trash_comment_nums(){
		return $this->User->get_amount('comment',' trash = 1 ');
	}
	
	/**
	 *
	 * 返回评论解释器信息数组
	 */
	private function get_comment_list($page,$require){
		$result			= NULL;
		$link 			= NULL;
		$comments 		= NULL;

		if($page == ''){
			$page = 1;
		}

		$page_nums = $this->get_page_nums('comment',$require);

		if($page > $page_nums){
			$page = $page_nums;
		}

		if($result = $this->User->get_result('comment','*',$require,AdminAction::PAGE_NUM,$page*
											AdminAction::PAGE_NUM - AdminAction::PAGE_NUM)){
			while($rows = mysql_fetch_array($result)){
				$comments[] = array('id'=>$rows['id'],'name'=>$rows['name'],
									'time'=>$rows['time'],'content'=>$rows['content'],'qq'=>$rows['qq'],
									'homepage'=>$rows['homepage']);
			}
		}

		if(is_array($comments)){
			return $comments;
		}else{
			return FALSE;
		}
	}

	private function dispose_comment_list($require = NULL){

		$page 				= $this->get_param("page");
		$do	 				= $this->get_param("do");
		$do_array			= $this->get_do_array($this->get_param("do_array"));
		

		switch ($do){
			case '':;break;
			case 'delete':
				$this->do_comment($do, $do_array);
				;break;
			case 'unpermit':
				$this->do_comment($do, $do_array);
				;break;	
			case 'permit':
				$this->do_comment($do, $do_array);
				;break;	
			case 'forbid':
				$this->do_comment($do, $do_array);
				;break;
			case 'trash':
				$this->do_comment($do, $do_array);
				;break;
			case 'untrash':
				$this->do_comment($do, $do_array);
				;break;
			default:;break;
		}

		//获取解释器信息
		/** 单变量信息 */
		$this->GXE->assign('all_comment_nums',$this->get_comment_nums());
		$this->GXE->assign('forbid_comment_nums',$this->get_forbid_comment_nums());
		$this->GXE->assign('permit_comment_nums',$this->get_permit_comment_nums());
		$this->GXE->assign('unpermit_comment_nums',$this->get_unpermit_comment_nums());
		$this->GXE->assign('untrash_comment_nums',$this->get_untrash_comment_nums());
		$this->GXE->assign('trash_comment_nums',$this->get_trash_comment_nums());
		/** 分页信息 */
		$pages = $this->get_page_array($page,'comment',$require);

		
		if($pages){
			$this->GXE->assign('pages',$pages);
		}else{
			$this->GXE->del_section('pages');
		}

		$this->GXE->assign('page_nums',$this->get_page_nums('comment',$require));

		/** 文章列表信息 */
		$comments = $this->get_comment_list($page,$require);
			
		if($comments){
			$this->GXE->assign('comments',$comments);
		}else{
			$this->GXE->del_section('comments');
		}
			
	}
	
	private function dispose_comment_edit(){
		$do = $this->get_param('do');
		
		switch($do){
			case 'show':
				$do_array = $this->get_do_array($this->get_param('do_array'));
				$do_id = $do_array[0];
				
				$result = $this->User->get_article_comments(null,"id = ".$do_id);
				
				$rows = null;
				$comment_name = null;
				$comment_qq = null;
				$comment_homepage = null;
				$comment_content = null;
				
				while($rows = mysql_fetch_array($result)){
					$comment_name = $rows['name'];
					$comment_qq = $rows['qq'];
					$comment_homepage = $rows['homepage'];
					$comment_content = $rows['content'];
				}
				
				
				$this->GXE->assign('comment_name',$comment_name);
				$this->GXE->assign('comment_qq',$comment_qq);
				$this->GXE->assign('comment_homepage',$comment_homepage);
				$this->GXE->assign('comment_content',$comment_content);
				$this->GXE->assign('comment_id',$do_id);
				$this->GXE->assign('message_show','none');

				;break;
			case 'post':
				
				$do_array = $this->get_do_array($this->get_param('do_array'));
				$do_id = $do_array[0];
				$comment_name = $this->get_param('name');
				$comment_qq = $this->get_param('qq');
				$comment_homepage = $this->get_param('homepage');
				$comment_content = $this->get_param('content');
				
				$sql = "UPDATE comment set name = '".$comment_name."', qq = '".$comment_qq."', content = '".
				$comment_content."', homepage = '".$comment_homepage."' WHERE id = ".$do_id;

				if(!$this->User->query($sql)){
					echo $sql;
					exit('IndexAction.class.php:error!');				
				}
				
				$this->GXE->assign('comment_name',$comment_name);
				$this->GXE->assign('comment_qq',$comment_qq);
				$this->GXE->assign('comment_homepage',$comment_homepage);
				$this->GXE->assign('comment_content',$comment_content);
				$this->GXE->assign('comment_id',$do_id);
				$this->GXE->assign('message_show','block');
				$this->GXE->assign('message_show_content','评论已更新。');
				;break;
			default:;break;
		}
		
	}
	
	private function get_theme_array(){
		$dir_array = array();
		$dir = ROOT_PATH.CONTENT_FOLDER.'/themes/';
		if (is_dir($dir)) {
  	 		if ($dh = opendir($dir)) {
   	   		 	while (($file = readdir($dh)) !== false) {
   	   		 		if($file != '.' && $file != '..' && $file != 'admin' && $file != 'install'){
   	   		 			array_push($dir_array, $file);
   	   		 		}
     			}
     	  		closedir($dh);
   			}
		}
		return $dir_array;
	}
	
	private function dispose_theme_show(){
		$dir = $this->get_theme_array();
		$this->GXE->assign('dir',$dir);
		$this->GXE->assign('message_show','none');
		$this->GXE->assign('message_show_content','主题已更新。');
	}
	
	private function dispose_theme_post(){
		
		$do = $this->get_param('do');
		$do_array = $this->get_param('do_array');
		
		switch ($do){
			case '':;break;
			case 'update':
				if($do_array == ''){
					break;
				}
				$string = file_get_contents(ROOT_PATH.SYSTEM_FOLDER.'/conf/site.inc.php');
				$pattern = "/(define\(\'TPL_NAME\',)(.*)(\))/";
				$replacement = "$1'".$do_array."'$3";
				$string = preg_replace($pattern, $replacement, $string);
				file_put_contents(ROOT_PATH.SYSTEM_FOLDER.'/conf/site.inc.php', $string);
				;break;
			default:;break;
		}
		
		$dir = $this->get_theme_array();
		$this->GXE->assign('dir',$dir);
		if($do_array == ''){
			$this->GXE->assign('message_show','block');
			$this->GXE->assign('message_show_content','请选择主题。');
		}else{
			$this->GXE->assign('message_show','block');
			$this->GXE->assign('message_show_content',$do_array.' 主题已应用。');
		}
	}
}