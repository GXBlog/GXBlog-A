<?php
/**
 * GXFilter 
 * 
 * Filter Params
 * 
 * @author GenialX
 * @since Alpha 0.1.0
 */
class GXFileter{

	/**
	 * Record param legal case
	 * 
	 * @var bool
	 */
	private $is_legal		= FALSE;
	
	public function __construct(){
		ObjectManager::set_object(ObjectManager::GXFILTER, $this);
		//Default Do
		$this->filter_p();
		$this->filter_tag();
	}
	
	/**
	 * Filter $_G['p'] and set property to global var $_G['p']
	 * 
	 * @sicne Alpha 0.1.0
	 */
	public function filter_p(){
		$this->set_legal(TRUE);
		return TRUE;
	}
	
	/**
	 * Filter $_G['tag'] and set property to global var $_G['tag']
	 * 
	 * @sicne Alpha 0.1.0
	 */
	public function filter_tag(){
		$this->set_legal(TRUE);
		return TRUE;
	}
	
	private function set_legal($is_legal){
		$this->is_legal	= $is_legal;
	}
	
	public function is_legal(){
		return $this->is_legal;
	}
	
}