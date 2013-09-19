<?php
/**
 * 根目录控制器
 */

Class HomeAction {

	private $SA 			= NULL;

	function __construct(){
		//Love You Forever... - 2013.08.17 By GenialX
		
		GXPlugin::get_instance();//OBSEVER ALL ACTIVE PLUGINS
		
		(INSTALL == FALSE)?$this->show_index():$this->install();
	}

	/**
	 *
	 * SHOW THEME
	 */
	private function show_index(){
		new GXFileter();
		new LoadTheme();
	}

	/**
	 *
	 * INSTALL GXBLOG
	 */
	private function install(){
		$InstallAction = new InstallAction();
		$InstallAction->show_install();
	}
}