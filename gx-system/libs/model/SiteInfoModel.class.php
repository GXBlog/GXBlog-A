<?php
/**
 * SiteInfo数据访问对象
 *
 * @version  0.1
 * @since 2013.08.18
 * @author GenialX
 * @link http://www.ihuxu.com
 */

class SiteInfoModel extends BaseModel{

	private static $instance 				= NULL;

	protected $table						= 'site_info';

	protected function __construct(){
		parent::__construct();
	}

	public static function get_instance(){
		if(!self::$instance instanceof self){
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	public function get_siteinfo(){
		return $this->fetch();
	}
	
	public function get_web_name(){
		$web_name_array = $this->fetch('web_name');
		return $web_name_array[0]['web_name'];
	}
	
	public function get_web_desc(){
		$web_desc_array = $this->fetch('web_desc');
		return $web_desc_array[0]['web_desc'];
	}

	public function get_web_statement(){
		$web_statement_array = $this->fetch('web_statement');
		return $web_statement_array[0]['web_statement'];
	}
	
	public function get_web_site(){
		$web_site_array = $this->fetch('web_site');
		return $web_site_array[0]['web_site'];
	}
	
	public function get_name(){
		$name_array = $this->fetch('name');
		return $name_array[0]['name'];
	}
	
	public function get_email(){
		$email_array = $this->fetch('email');
		return $email_array[0]['email'];
	}
	
	public function get_qq(){
		$qq_array = $this->fetch('qq');
		return $qq_array[0]['qq'];
	}
	
	public function get_web_record(){
		$record_array = $this->fetch('record');
		return $record_array[0]['record'];
	}
	
	public function get_web_copyright(){
		$copyright_array = $this->fetch('copyright');
		return $copyright_array[0]['copyright'];
	}
}
