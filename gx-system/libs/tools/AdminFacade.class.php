<?php
/**
 * 
 * Admin Facade Interface
 */
class AdminFacade{
	public static function show_index(){
		$GXEngien = new GXEngien();
		$GXEngien->templates_dir = ROOT_PATH.SYSTEM_FOLDER."/templates/admin/";
		$AdminAction = new AdminAction($GXEngien);
		$AdminAction->show_index();
	}
}