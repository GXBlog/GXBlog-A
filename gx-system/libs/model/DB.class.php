<?php 
/**
 * @desc 这是一个类文件，处理有关数据库的业务逻辑。
 */

Class DB{
	
	protected static $instance = NULL;

	/**
	 * 
	 * @desc 数据库类(Database)构造函数,
	 *		  功能：链接数据库，设置默认的文字编码
	 * @return BOOLEAN 成功返回TRUE,失败返回FALSE
	 */
	protected function __construct()
	{
		//连接数据库
		if( !mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) ){
			return  FALSE;
		}else {	
			//请求数据库，设置创建数据表时的默认的文字编码	
			mysql_query("set names ".DB_CHARSET);
			return TRUE;
		}
	}
	
	public static function get_instance(){
		if(!self::$instance instanceof self){
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	/**
	 * 
	 * @desc 析构函数
	 * @return TRUE
	 */
	function __destruct()
	{
		return TRUE;
	}
	
	/**
	 * 
	 * @desc 选择数据库
	 * @return BOOLEAN 成功返回TRUE,失败返回FALSE
	 */
	public function select_db($db_name = NULL)
	{
		if( !isset($db_name) )
		{
			$db_name = DB_NAME;
		}
		if ( mysql_select_db($db_name))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	 * 
	 * @desc 设置数据库默认连接字符编码
	 * @return boolean 成功返回TRUE,失败返回FALSE
	 */
	public function set_charset( $charset = NULL)
	{
		if( !isset($charset))
		{
			$charset = DB_CHARSET;
		}
		
		if ( mysql_query("set names ".$charset) )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	 * 
	 * @desc 模拟mysql_query()函数，对参数进行防注入的处理
	 * @return BOOLEAN/array 返回的具体内容，以请求语句而定
	 */
	public function query($query)
	{
		$result = mysql_query($query);
		return $result;
	}

}
?>