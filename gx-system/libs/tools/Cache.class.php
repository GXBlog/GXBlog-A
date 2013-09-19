<?php
/**
 * 缓存类 - 外观模式
 */

class Cache{
	
	private $GXEngien 							= NULL;
	private $show								= FALSE;
	private $generate							= FALSE;
	private $cache								= FALSE;
	private $cache_filename						= NULL;
	
	public function __construct($GXEngien){
		$this->GXEngien 						= $GXEngien;
		$this->cache							= $GXEngien->cache;
		$this->cache_filename					= 'index.cache';
	}
	
	public function show_cache(){
		$this->set_show(FALSE);
		if($this->cache){
			if( $this->GXEngien->is_exits_file($this->GXEngien->cache_dir,$this->cache_filename) && !$this->GXEngien->is_overdue($this->GXEngien->cache_dir,$this->cache_filename)){
				$this->GXEngien->show_static_html($this->GXEngien->cache_dir,$this->cache_filename);
				$this->set_show(TRUE);
				return TRUE;
			}
		}
		$this->set_show(FALSE);
		return FALSE;
	}
	
	public function generate_cache(){
		$this->set_generate(FALSE);
		if($this->GXEngien->cache){
			if( !$this->GXEngien->is_exits_file($this->GXEngien->cache_dir,$this->cache_filename) || $this->GXEngien->is_overdue($this->GXEngien->cache_dir,$this->cache_filename)){
				$this->GXEngien->generate_static_html($this->GXEngien->cache_dir,$this->cache_filename);
				$this->set_generate(TRUE);
				return TRUE;
			}
		}
		$this->set_generate(FALSE);
		return FALSE;
	}
	
	public function show_file(){
		$this->set_show(FALSE);
		if( $this->GXEngien->is_exits_file($this->GXEngien->cache_dir,$this->cache_filename)){
			$this->GXEngien->show_static_html($this->GXEngien->cache_dir,$this->cache_filename);
			$this->set_show(TRUE);
			return TRUE;
		}
		$this->set_show(FALSE);
		return FALSE;
	}
	
	private function set_show($show){
		$this->show = $show;
	}
	
	private function set_generate($generate){
		$this->generate = $generate;
	}
	
	public function is_show(){
		return $this->show;
	}
	
	public function is_generate(){
		return $this->generate;
	}
	
	public function set_cache_filename($filename){
		$this->cache_filename = $filename;
		return TRUE;
	}
	
	public function is_cache(){
		return $this->cache;
	}
	
	public function get_cache_filename($filename){
		if( ! is_null($this->cache_filename) ){
			return $this->cache_filename;
		}
		return FALSE;
	}
}