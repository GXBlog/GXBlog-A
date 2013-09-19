<?php
/**
 * Comment数据访问对象
 *
 * @version  0.1
 * @since 2013.08.16
 * @author GenialX
 * @link http://www.ihuxu.com
 */

class CommentModel extends BaseModel{

	private static $instance 				= NULL;

	protected $table						= 'comment';

	protected function __construct(){
		parent::__construct();
	}

	public static function get_instance(){
		if(!self::$instance instanceof self){
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	public function get_comments($num = NULL){
		$require[0] = array('trash'=>0,'is_show'=>1);
		$require[1] = array(0=>'and');
		
		$LogicSqlRequire = new LogicSqlRequire($require);
		
		return $this->fetch(null,$LogicSqlRequire,$num);
	}
	
	public function get_article_comments($id){
		$require[0] = array('trash'=>0,'is_show'=>1,'article_id'=>$id);
		
		$SingleSqlRequire = new SingleSqlRequire($require);
		
		return $this->fetch(null,$SingleSqlRequire);
	}
}