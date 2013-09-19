<?php
/**
 * ISay数据访问对象
 *
 * @version  0.1
 * @since 2013.08.18
 * @author GenialX
 * @link http://www.ihuxu.com
 */

class ISayModel extends BaseModel{

	private static $instance 				= NULL;

	protected $table						= 'isay';

	protected function __construct(){
		parent::__construct();
	}

	public static function get_instance(){
		if(!self::$instance instanceof self){
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	public function get_isays($num = NULL){
		return $this->fetch(null,null,$num);
	}
}