<?php
/**
 * GXParamEooroPage
 * 
 * Show param error page
 * 
 * @author GenialX
 * @since Alpha 0.1.0
 */

class GXParamErrorPage extends GXPage{
	
	public function __construct($template = NULL){
		
		$this->get_engien();
		
		$this->set_template_dir(ROOT_PATH . SYSTEM_FOLDER . '/templates/page/error/');
		
		if(! is_null($template)){
			$this->set_template($template);
		}else{
			$this->set_template('gx_param_error.html');
		}
		
	}
}