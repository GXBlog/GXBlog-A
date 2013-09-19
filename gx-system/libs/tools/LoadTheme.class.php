<?php
/**
 *
 * TELL GXBLOG HOW TO LOAD THEME
 */
class LoadTheme {

	/**
	 * GXFilter
	 * 
	 * Filter global vars,such as $G_['p']、$G_['tag'] and so on
	 * 
	 * @since Alpha 0.1.0
	 * @access private
	 * @var Object
	 */
	private $GXF;
	
	public function __construct(){	
			
		$this->GXF = ObjectManager::get_object(ObjectManager::GXFILTER);
		
		if(class_exists('TemplateAction')){
			$this->load_template_action();
		}elseif(file_exists(ROOT_PATH . CONTENT_FOLDER . '/themes/' . TPL_NAME . '/index.php')){
			$this->load_template_model();
		}else{
			exit('LoadTheme: Load Theme Error!');
		}
	}

	private function load_template_action(){
		
		$GXAT= new GXActionTheme();
		
		if( ! $this->GXF->is_legal()){
			$GXAT->show_404();
			return;
		}

		if(isset($_GET['p'])){
			$GXAT->show_archive($_GET['p']);
		}else if(isset($_GET['tag'])){
			$GXAT->show_tag($_GET['tag']);
		}else {
			$GXAT->show_index();
		}
	}

	/**
	 * Model THEME EXTENDED
	 *
	 * @access private
	 * @since Alpha 0.1.0
	 * @author GenialX
	 */
	private function load_template_model(){
		
		require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/ModelThemeFunctions.php';

		//Declare Global Vars
		global $gx_query, $gx_template, $post, $comment;
		global $site_model, $article_model, $comment_model, $gxplugin;
		global $text_filter;

		$gx_template 	= new GXTemplate();

		$site_model 	= SiteInfoModel::get_instance();

		$article_model	= ArticleModel::get_instance();
		
		$comment_model	= CommentModel::get_instance();

		$gxplugin		= GXPlugin::get_instance();

		$text_filter 	= new TextFilter();
		
		if( ! $this->GXF->is_legal()){
			if(file_exists(ROOT_PATH . CONTENT_FOLDER . '/themes/' .TPL_NAME . '/404.php')){
				require_once ROOT_PATH . CONTENT_FOLDER . '/themes/' .TPL_NAME . '/404.php';
			}else{
				$GX404 = new GXParamErrorPage();
				$GX404->set_content('GenialX Alert!');
				$GX404->show();
				return;
			}
		}

		if(isset($_GET['p'])){
			$gx_query 		= new GXQuery( array('p' => $_GET['p']) );
			require_once ROOT_PATH . CONTENT_FOLDER . '/themes/' .TPL_NAME . '/archive.php';
			return;
		}

		if(isset($_GET['tag'])){
			$gx_query 		= new GXQuery( array('tag' => $_GET['tag']) );
			require_once ROOT_PATH . CONTENT_FOLDER . '/themes/' . TPL_NAME . '/list.php';
			return;
		}

		$gx_query 		= new GXQuery();
		require_once ROOT_PATH . CONTENT_FOLDER . '/themes/' . TPL_NAME . '/index.php';
	}
}