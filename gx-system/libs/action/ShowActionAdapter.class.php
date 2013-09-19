<?php
/**
 * 模板扩展控制器抽象类适配器类
 * 
 * 一个静静的夜晚、身体格外轻松、心情平静了许多、也许这就是幸福吧  - 2013.08.19 03:29  By GenialX
 */

class ShowActionAdapter extends ShowAction{
	
	/**
	 * Show Index Adapter Function
	 * 
	 * Tell the GXBlog how to show index page
	 * Wheather show index cache or re-generate tag page
	 * 
	 * @since Alpha 0.0.1
	 * @see ShowAction::show_index()
	 */
	protected function show_index(){}
	
	/**
	 * Show Tag Adapter Function
	 * 
	 * Tell the GXBlog how to show tag page
	 * Wheather show tag cache or re-generate tag page
	 * 
	 * @since Alpha 0.0.1
	 * @see ShowAction::show_tag()
	 */
	protected function show_tag($tag){}
	
	/**
	 * Show Archive Adapter Function
	 * 
	 * Tell the GXBlog how to show archive page
	 * Wheather show archive cache or re-generate archive page
	 * 
	 * @since Alpha 0.0.1
	 * @see ShowAction::show_archive()
	 */
	protected function show_archive($p){}
	
	/**
	 * Sub Class Need To Rewrite
	 * 
	 * Generate home page's cache file
	 * 
	 * @since Alpha 0.1.0
	 * @see ShowAction::generate_index()
	 */
	protected function generate_index(){}
	
	/**
	 * Sub Class Need To Rewrite
	 * 
	 * Generate tag page's cache file
	 * 
	 * @since Alpha 0.1.0
	 * @see ShowAction::generate_tag()
	 */
	protected function generate_tag($tag){}
	
	/**
	 * Sub Class Need To Rewrite
	 * 
	 * Generate the archive's cache file
	 * 
	 * @since Alpha 0.0.1
	 * @see ShowAction::generate_archive()
	 */
	protected function generate_archive($tag){}

	/**
	 * Generate Index Cache File
	 * 
	 * @since Alpha 0.1.0
	 */
	protected function generate_index_cache(){
		$this->generate_static_html(ROOT_PATH . SYSTEM_FOLDER .'/cache/', 'gx_index.cache');
	}
	
	/**
	 * Generate Archive Cache File
	 * 
	 * @since Alpha 0.1.0
	 */
	protected function generate_archive_cache($p){
		$this->generate_static_html(ROOT_PATH . SYSTEM_FOLDER .'/cache/gx_archive_', $p . '.cache');
	}
	
	/**
	 * Generate Tag Cache File
	 * 
	 * @since Alpha 0.1.0
	 */
	protected function generate_tag_cache($tag){
		$this->generate_static_html(ROOT_PATH . SYSTEM_FOLDER .'/cache/gx_tag_', $tag . '.cache');
	}
	
	/**
	 * Show 404 Page
	 * 
	 * @since Alpha 0.1.0
	 * @see ShowAction::show_404()
	 */
	public function show_404(){
		echo '<h1>404</h1>';
		echo "<h2><a href='" . HOME_PATH . "' target='_self'> Home </a></h2>";
	}
	
	/**
	 * Allow Sub Class To Use Display Function
	 * 
	 * @since Alpha 0.1.0
	 * @see ShowAction::display()
	 */
	public function _display(){
		$this->display();
	}

}