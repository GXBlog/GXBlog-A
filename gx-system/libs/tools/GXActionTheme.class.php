<?php
/**
 * GXActionTheme
 * 
 * Dispose action theme logic
 * 
 * @author GenialX
 * @since Alpha 0.1.0
 */

class GXActionTheme{
	
	/**
	 * TemplateAction Handle
	 * 
	 * @var TemplateAction
	 * @since Alpha 0.1.0
	 * @access private
	 */
	private $TA;
	
	/**
	 * Cache
	 * 
	 * @var Cache
	 * @since Alpha 0.1.0
	 * @access private
	 */
	private $C;
	
	public function __construct(){
		$this->TA = new TemplateAction();
		$this->C  = ObjectManager::get_object(ObjectManager::TemplateActionCache);
	}
	
	public function show_index(){
		// index cache file name format - [gx_index.cache]
		$this->C->set_cache_filename('gx_index.cache');
		if($this->C->is_cache()){//CACHE
			if( ! $this->C->show_cache()){
				$this->TA->generate_index();
				$this->TA->_display();
			} 
		}else{//NO CACHE
			$this->TA->generate_index();
			$this->TA->_display();
		}
	}
	
	public function show_tag($tag){
		//tag cache file name format - [gx_tag_{$tag}.cache]
		$this->C->set_cache_filename('gx_tag_' . $tag . '.cache');
		if($this->C->is_cache()){
			if( ! $this->C->show_cache()){
				$this->TA->generate_tag($tag);
				$this->TA->_display();
			} 
		}else{
			$this->TA->generate_tag($tag);
			$this->TA->_display();
		}
	}
	
	public function show_archive($p){
		//archive cache file name format - [gx_archive_{$p}.cache]
		$this->C->set_cache_filename('gx_archive_' . $p . '.cache');
		if($this->C->is_cache()){
			if( ! $this->C->show_cache()){
				$this->TA->generate_archive($p);
				$this->TA->_display();
			}
		}else{
			$this->TA->generate_archive($p);			
			$this->TA->_display();
		}
	}
	
	public function show_404(){
		$this->TA->show_404();
	}
}