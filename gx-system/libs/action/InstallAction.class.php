<?php
/**
 * 程序部署控制器
 */

Class InstallAction{

	//私有变量声明
	private $GXEngien 		= NULL;
	private $User 			= NULL;
	
	/**
	 * 构造函数
	 * @param unknown_type $GXEngien
	 */
	function __construct(){
		$this->GXEngien = new GXEngien();
		$this->GXEngien->templates_dir = ROOT_PATH.SYSTEM_FOLDER."/templates/install/";//模板的路径
	}
	
//程序部署实现
	public function show_install(){
		
	if(isset($_GET['step'])){
			$step = $_GET['step'];
		}else{
			$step = 0;
		}


				
		switch ($step){
			case 0:
				$this->GXEngien->dispose_filename("install_1.html");
				$this->GXEngien->display();
				;break;
			case 1:
				$this->GXEngien->dispose_filename("install_2.html");
				$this->GXEngien->display();	
				;break;
			case 2:
				
				$dbhost		= $_GET['dbhost'];
				$uname 		= $_GET['uname'];
				$pwd 		= $_GET['pwd'];
				$dbname		= $_GET['dbname'];
				$prefix		= $_GET['prefix'];
				$site_path	= $_GET['site_link'];
		
				if(mysql_connect($dbhost,$uname,$pwd)){
					$query = "use ".$dbname;
					$result = mysql_query($query);
					if($result == 1){
						//IO流操作
						$filename = ROOT_PATH.SYSTEM_FOLDER."/conf/site.inc.php";
						$handle_in = fopen($filename, "r");
						$contents = fread($handle_in, filesize ($filename));
						fclose($handle_in);
						
						$contents = str_replace("database_name_here", $dbname, $contents);
						$contents = str_replace("username_here", $uname, $contents);
						$contents = str_replace("password_here", $pwd, $contents);
						$contents = str_replace("localhost", $dbhost, $contents);
						$contents = str_replace("gx_", $prefix, $contents);
						$contents = str_replace("site_path_here", $site_path, $contents);
						
						$handle_out = fopen($filename, "w");
						fwrite($handle_out, $contents);
						fclose($handle_out);
						
						$this->GXEngien->dispose_filename("install_suc_3.html");
						$this->GXEngien->display();
						return;
					}
				}
				$this->GXEngien->dispose_filename("install_fai_3.html");
				$this->GXEngien->display();
				;break;
			case 3:
				//初始化数据库
				$this->ini_db();
				
				//获取站点基本信息
				$this->GXEngien->dispose_filename("install_4.html");
				$this->GXEngien->display();
				;break;
			case 4:
				$this->User = new User();
				
				$uname = $_GET['uname'];
				$pwd = $_GET['pwd_first'];
				$email = $_GET['email'];
				$web_name = $_GET['site_title'];
								
				$query = "insert into user (username,password,email) values ('$uname','$pwd','$email')";
				$this->User->query($query);
				
				$query = "insert into site_info (id,web_name,web_desc,copyright,record,web_statement,web_site,name,email,qq) value (1,'$web_name','又一个GXBlog站点','版权','备案号','声明','网站地址','站长','邮箱','QQ')";
				$this->User->query($query);
				
				//IO流操作
				$filename = ROOT_PATH.SYSTEM_FOLDER."/conf/site.inc.php";
				$handle_in = fopen($filename, "r");
				$contents = fread($handle_in, filesize ($filename));
				fclose($handle_in);

				$contents = preg_replace("/(define\(\'INSTALL\',)(.*)(\))/", "$1FALSE$3", $contents);
							
				$handle_out = fopen($filename, "w");
				fwrite($handle_out, $contents);
				fclose($handle_out);
				
				$STA = new TemplateAction();
				$STA->generate_archive(1);
				
				$this->GXEngien->dispose_filename("install_5.html");
				$this->GXEngien->display();
				
				;break;
			default:;break;		
		}
	}
	
/**
	 * 程序部署数据库初始化
	 */
	public function ini_db(){
		
		require_once dirname(dirname(__FILE__)).'/model/Db.class.php';
		
		$DB = DB::get_instance();
		$DB->select_db();
		
		$query = "CREATE TABLE IF NOT EXISTS `article` (
				  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
				  `name` char(10) NOT NULL COMMENT '作者',
				  `title` char(50) NOT NULL COMMENT '文章标题',
				  `content` longtext NOT NULL COMMENT '文章正文',
				  `time` char(20) NOT NULL COMMENT '发表时间',
				  `tags` char(50) NOT NULL COMMENT '标签云',
				  `comment` int(5) NOT NULL DEFAULT '0' COMMENT '评论',
				  `like` int(5) NOT NULL DEFAULT '0' COMMENT '喜欢',
				  `trash` tinyint(1) DEFAULT '0' COMMENT '垃圾标志',
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;";
		$DB->query($query);
		
		$query = "INSERT INTO `article` (`id`, `name`,`title`, `content`, `time`, `tags`, `comment`, `like`) VALUES
				(1, 'GXBlog','欢迎使用GXBlog!', '欢迎使用 GXBlog。这是系统自动生成的演示文章。编辑或者删除它，然后开始您的博客！', '2013-03-06 00:00:00', 'demo', 0, 0);";
		$DB->query($query);
		
		$query = "CREATE TABLE IF NOT EXISTS `comment` (
				  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
				  `article_id` int(10) NOT NULL COMMENT '关联的文章的id',
				  `name` char(30) NOT NULL COMMENT '评论者名字',
				  `time` char(20) NOT NULL COMMENT '时间',
				  `qq` char(10) NOT NULL COMMENT 'QQ',
				  `homepage` char(60) NOT NULL COMMENT 'Homepage',
				  `content` char(200) NOT NULL COMMENT '评论内容',
				  `is_show` tinyint(1) NOT NULL DEFAULT '0' COMMENT '显示标志',
				  `trash` tinyint(1) DEFAULT '0',
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=gb2312 AUTO_INCREMENT=2 ;";
		$DB->query($query);
		
		$query = "INSERT INTO `comment` (`id`, `article_id`, `name`, `time`, `qq`, `homepage`, `content`, `is_show`) VALUES
				(0, 1, 'GenialX', '2013-03-06 00:00:00', '2252065614', 'http://www.ihuxu.com', '您好，这是一条有系统自动生成的评论。登陆后，方可编辑或者删除它。', 1);";
		$DB->query($query);
		
		$query = "CREATE TABLE IF NOT EXISTS `isay` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `content` varchar(500) COLLATE utf8_bin NOT NULL,
				  `time` char(30) COLLATE utf8_bin NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;";
		$DB->query($query);
		
		$query = "INSERT INTO `isay` (`id`, `content`, `time`) VALUES
				(1, '您好，这是一条友系统自动生成的iSay。登陆后，方可编辑或者删除它。', '2013-03-06 00:00:00');";
		$DB->query($query);
		
		$query = "CREATE TABLE IF NOT EXISTS `moodsay` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `time` char(20) COLLATE utf8_bin NOT NULL,
				  `content` char(200) COLLATE utf8_bin NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;";
		$DB->query($query);
								
		$query = "INSERT INTO `moodsay` (`id`, `time`, `content`) VALUES
				(1, '2013-03-06 00:00:00', '您好，这是一条由系统自动生成的moodSay。登陆后，方可编辑或者删除它。');";
		$DB->query($query);
				
		$query = "CREATE TABLE IF NOT EXISTS `site_info` (
				  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
				  `web_name` char(20) NOT NULL COMMENT '网站名称',
				  `copyright` char(20) NOT NULL COMMENT '版权',
				  `qq` char(20) NOT NULL COMMENT 'qq',
				  `email` char(40) NOT NULL COMMENT '邮箱',
				  `web_statement` char(50) NOT NULL COMMENT '声明',
				  `web_site` char(50) NOT NULL COMMENT '网站地址',
				  `web_desc` char(50) NOT NULL COMMENT '描述',
				  `name` char(20) NOT NULL,
				  `record` char(30) NOT NULL COMMENT '备案号',
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='网站基本信息' AUTO_INCREMENT=2";
		$DB->query($query);
		
		$query = "CREATE TABLE IF NOT EXISTS `user` (
				  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '主键',
				  `username` char(20) NOT NULL COMMENT '用户名',
				  `password` char(20) NOT NULL COMMENT '密码',
				  `email` char(30) NOT NULL COMMENT '邮箱',
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;";
		$DB->query($query);
	}

}