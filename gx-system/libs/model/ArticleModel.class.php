<?php
/**
 * Aritcle数据访问对象
 *
 * @version  0.1
 * @since 2013.08.16
 * @author GenialX
 * @link http://www.ihuxu.com
 */

class ArticleModel extends BaseModel{

	private static $instance 				= NULL;

	protected $table						= 'article';

	/**
	 * 肚子很饿 - 2013.08.24 08:41 By GenialX
	 */
	protected function __construct(){
		parent::__construct();
	}

	public static function get_instance(){
		if(!self::$instance instanceof self){
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	public function get_articles($num = NULL,$SqlRequire = NULL){
		if(is_null($SqlRequire)){
			$require[0] = array('trash'=>'0');
			$SqlRequire = new SingleSqlRequire($require);
		}
		return $this->fetch(NULL,$SqlRequire,$num);
	}
	
	public function get_random_articles($num = NULL){		
		$require[0] = array('trash'=>'0');
		$SingleSqlRequire = new SingleSqlRequire($require);
		return $this->fetch(NULL,$SingleSqlRequire,$num,NULL,'RAND()','');
	}
	
	public function get_tags($num = NULL){
		$require[0] = array('trash'=>'0');
		$SingleSqlRequire = new SingleSqlRequire($require);
		return $this->fetch('tags',$SingleSqlRequire,$num);
	}
	
	public function get_articles_by_tag($tag,$num = NULL){
		
		$require[0] = array('tags'=>'%'.$tag.'%','trash'=>'0');
		$require[1] = array(0=>'AND');
		$require[2] = array(0=>'LIKE',1=>'=');
		
		$RelationSqlRequire = new RelationSqlRequire($require);
		
		return $this->fetch(NULL,$RelationSqlRequire,$num);
	}
	
	public function get_article_link($id){
		$pre = (FALSE_STATIC == TRUE)?'True':'False';
		$class_name = $pre.'StaticArticleLink';
		$StaticArticleLink = new $class_name;
		return $StaticArticleLink->get_link($id);
	}
	
	public function get_true_static_article_link($id){
		$TrueStaticArticleLink = new TrueStaticArticleLink();
		return $TrueStaticArticleLink->get_link($id);
	}
	
	public function get_false_static_article_link($id){
		$FalseStaticArticleLink = new FalseStaticArticleLink();
		return $FalseStaticArticleLink->get_link($id);
	}
	
	public function get_article_name($id){
		$link = $this->get_true_static_article_link($id);
		if($link == FALSE){
			return FALSE;
		}
		
		preg_match("/(p\/)(.*)/",$link, $matches);
		return $matches[2];
	}
	
	public function get_article_title($id){
		$require[0] = array('id'=>$id);
		$SingleSqlRequire = new SingleSqlRequire($require);
		$result = $this->fetch('title',$SingleSqlRequire);
		if($result != FALSE){
			return $result[0]['title'];
		}
		return FALSE;
	}
	
	public function get_article_time($id){
		$require[0] = array('id'=>$id);
		$SingleSqlRequire = new SingleSqlRequire($require);
		$result = $this->fetch('time',$SingleSqlRequire);
		if($result != FALSE){
			return $result[0]['time'];
		}
		return FALSE;
	}
	
	public function get_article_content($id){
		$require[0] = array('id'=>$id);
		$SingleSqlRequire = new SingleSqlRequire($require);
		$result = $this->fetch('content',$SingleSqlRequire);
		if($result != FALSE){
			return $result[0]['content'];
		}
		return FALSE;
	}
	
	public function get_article_tags($id){
		$require[0] = array('id'=>$id);
		$SingleSqlRequire = new SingleSqlRequire($require);
		$result = $this->fetch('tags',$SingleSqlRequire);
		if($result != FALSE){
			return $result[0]['tags'];
		}
		return FALSE;
	}
	
	public function get_article_like($id){
		$require[0] = array('id'=>$id);
		$SingleSqlRequire = new SingleSqlRequire($require);
		$result = $this->fetch('like',$SingleSqlRequire);
		if($result != FALSE){
			return $result[0]['like'];
		}
		return FALSE;
	}
	
	public function get_article_comment($id){
		$require[0] = array('id'=>$id);
		$SingleSqlRequire = new SingleSqlRequire($require);
		$result = $this->fetch('comment',$SingleSqlRequire);
		if($result != FALSE){
			return $result[0]['comment'];
		}
		return FALSE;
	}
	
	public function get_tag_link($tag){
		$pre = (FALSE_STATIC == TRUE)?'True':'False';
		$class_name = $pre.'StaticTagLink';
		$StaticTagLink = new $class_name;
		return $StaticTagLink->get_link($tag);
	}
	
}