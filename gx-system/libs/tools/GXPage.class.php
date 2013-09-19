<?php
/**
 * GXPage
 * 
 * Show some user-defined content page
 * 
 * @author GenialX
 * @since Alpha 0.1.0
 * @date 2013.09.18
 */

class GXPage{
	
	/**
	 * Template filename
	 * 
	 * @access private
	 * @since Alpha 0.1.0
	 * @var string
	 */
	private $template = '';
	
	/**
	 * Template filepath
	 * 
	 * @access private
	 * @since Alpha 0.1.0
	 * @var string
	 */
	private $template_dir = '';
	
	/**
	 * Template file content
	 * 
	 * @access private
	 * @since Alpha 0.1.0
	 * @var string
	 */
	private $content = '';
	
	/**
	 * GXEngine
	 * 
	 * @access private
	 * @since Alpha 0.1.0
	 * @var Object
	 */
	private $GXE = NULL;
	
	
	public function __construt(){
		//时间静静地走、人们慢慢的变。中秋了、也许换换地方合适些...  2013.09.18  By GenialX
		$this->set_template_dir(ROOT_PATH . SYSTEM_FOLDER . '/templates/page/');
		$this->get_engien();
	}

	public function set_template_dir($template_dir){
		$this->template_dir			= $template_dir;
		$this->GXE->templates_dir	= $template_dir;
	}
	
	public function set_template($template){
		$this->template	= $template;
		$this->GXE->dispose_filename($template);
	}
	
	public function set_content($content){
		$this->content = $content;
		$this->GXE->assign('content',$content);
	}
	
	public function show(){
		$this->GXE->display();
	}
	
	public function get_engien(){
		if(is_null($this->GXE)){
			$this->GXE = new GXEngien();
			return TRUE;
		}
	}
}