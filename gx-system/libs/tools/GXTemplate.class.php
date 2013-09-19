<?php
/**
 * GXBlog Template
 * 
 * 模板类 - 用于对模板文件的处理
 * 
 * @name GenialX
 * @since Alpha 0.1.0
 */
class GXTemplate {
	
	public function __construct(){
		//DO NOTHING
	}
	
	public function get_header($name = NULL){
		$name = (string) $name;
			
        $templates = 'header.php';
        
        if ( '' !== $name )         
        	$templates = "header-{$name}.php";
        
        if(file_exists( ROOT_PATH . CONTENT_FOLDER .'/themes/' . TPL_NAME . '/' . $templates )){
        	require ROOT_PATH . CONTENT_FOLDER .'/themes/' . TPL_NAME . '/'. $templates ;
        }else{
        	exit('GXTemplate: Load Header.php File Error!');
        }
	}
	
	public function get_sidebar($name = NULL){
		$name = (string) $name;
		
        $templates = 'sidebar.php';
        
        if ( '' !== $name )         
        	$templates = "sidebar-{$name}.php";
	
        
        if(file_exists( ROOT_PATH . CONTENT_FOLDER .'/themes/' . TPL_NAME . '/' . $templates )){
        	require ROOT_PATH . CONTENT_FOLDER .'/themes/' . TPL_NAME . '/' .$templates ;
        }else{
        	exit('GXTemplate: Load Sidebar.php File Error!');
        }
	
	}
	
	public function get_footer($name = NULL){
		$name = (string) $name;
		
		$templates = 'footer.php';
		
        if ( ''  !== $name )         
        	$templates = "footer-{$name}.php";
        
        if(file_exists( ROOT_PATH . CONTENT_FOLDER .'/themes/' . TPL_NAME . '/' .$templates )){
        	require ROOT_PATH . CONTENT_FOLDER .'/themes/' . TPL_NAME . '/' .$templates ;
        }else{
        	exit('GXTemplate: Load Footer.php File Error!');
        }
	}
	
	public function get_template_part( $slug, $name = NULL ){
		
        $name = (string) $name;
        
        if ( '' !== $name )
	   		 $templates = "{$slug}-{$name}.php";
	
	    $templates = "{$slug}.php";
	    
	    if(file_exists( ROOT_PATH . CONTENT_FOLDER .'/themes/' . TPL_NAME . '/' . $templates )){
        	require ROOT_PATH . CONTENT_FOLDER .'/themes/' . TPL_NAME . '/' . $templates ;
        }else{
        	exit("GXTemplate: Load {$templates} File Error!");
        }
	}
	
}