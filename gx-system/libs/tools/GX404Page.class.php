<?php
/**
 * GX404
 * 
 * Show 404 page
 * 
 * @author GenialX
 * @since Alpha 0.1.0
 */

class GX404Page extends GXPage{
	
	public function __construct($template = NULL){
		
		$this->get_engien();
		
		$this->set_template_dir(ROOT_PATH . SYSTEM_FOLDER . '/templates/page/404/');
		
		if(! is_null($template)){
			$this->set_template($template);
		}else{
			$this->set_template('gx_404.html');
		}
		
	}
}