<?php
/**
 * GXBlog Plugin Manager Class
 *
 * 插件扩展基类，用于管理GXBlog的第三方插件，受到STBlog的启发。
 * 
 * @name GenialX
 * @link http://www.ihuxu.com
 */
class GXPlugin{
	
	/**
	 * 单利句柄
	 */
    private static $instance 	= NULL;
    
	/**
     * 已注册的插件(类和方法)
     */
    private $_listeners 		= array();
    

	 /**
      * 构造函数
      * 
      * @return void
      */
    protected function __construct(){
    	
		$plugins = $this->get_active_plugins();
		
		if($plugins && is_array($plugins)){
			foreach($plugins as $plugin){
				
				$plugin_dir = $plugin['directory'] . '/' . $plugin['directory'] . '.class.php';
			
				$path = ROOT_PATH . CONTENT_FOLDER . '/plugins/' . $plugin_dir;
				
				if (file_exists($path)){
					
					include_once($path);

					$class = $plugin['directory'];
					
					if (class_exists($class)) 
					{
						/** 初始化插件 */
						new $class($this);
					}
				}
			}
		}
//		log_message('debug', "GXBlog: Plugins Libraries Class Initialized");
    }
    
    public static function get_instance(){
    	if(!self::$instance instanceof self){
			self::$instance = new self;
		}
		return self::$instance;
    }
	
	/**
	 * 注册需要监听的插件方法（钩子）
	 *
	 * @param string $hook
	 * @param object $reference
	 * @param string $method
	 */
	public function register($hook, &$reference, $method)
	{
		$key = get_class($reference).'->'.$method;
		$this->_listeners[$hook][$key] = array(&$reference, $method);
		
//		log_message('debug', "$hook Registered: $key");
	}

	/**
	 * 触发一个钩子
	 *
	 *	e.g.: $this->plugin->trigger('hook_name'[, arg1, arg2, arg3...]);	
	 *
	 * @param string $hook 钩子的名称
	 * @param mixed $data 钩子的入参
	 * @return mixed
	 */
	public function trigger($hook){
		
		$result = '';
		
		if($this->check_hook_exist($hook)){
			
			foreach ($this->_listeners[$hook] as $listener){
				
				$class  = & $listener[0];
				$method = $listener[1];
				
				if(method_exists($class, $method)){
					
					$args = array_slice(func_get_args(), 1);
					
					$result = call_user_func_array(array($class, $method), $args);
				}
			}
		}
		
//		log_message('debug', "Hook Triggerred: $hook");
		
		return $result;
	}

	/**
	 * 检查钩子是否存在
	 *
	 *
	 * @param string $hook 钩子的名称
	 * @return array
	 */
	private function check_hook_exist($hook){
		if(isset($this->_listeners[$hook]) && is_array($this->_listeners[$hook]) && count($this->_listeners[$hook]) > 0){
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * 获取激活插件
	 * 
	 */
	private function get_active_plugins(){
		
		$dir = ROOT_PATH . CONTENT_FOLDER.'/plugins/';
		
		if (is_dir($dir)) {
  	 		if ($dh = opendir($dir)) {
   	   		 	while (($file = readdir($dh)) !== false) {
   	   		 		if($file != '.' && $file != '..'){
   	   		 			$plugins[] = array('directory'=>$file);
   	   		 		}
     			}
     	  		closedir($dh);
   			}
		}
		
		if(!isset($plugins)){
			return FALSE;
		}
		
		return $plugins;
	}
}