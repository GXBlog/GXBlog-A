<?php
/**
 * 模板扩展控制器抽象类
 */

abstract class ShowAction{

	private $User									= NULL;
	private $Article								= NULL;
	private $Comment								= NULL;
	private $ISay									= NULL;
	private $MoodSay								= NULL;
	private $SiteInfo								= NULL;
	private $GXEngien 								= NULL;
	private $Cache									= NULL;
	private $TF										= NULL;
	private $GXPlugin								= NULL;
	
	/**
	 * 
	 * 阳光明媚的下午，一切都是那么的平静  - 2013.08.18 By GenialX
	 */
	public function __construct(){
		$this->User									= UserModel::get_instance();
		$this->Article								= ArticleModel::get_instance();
		$this->Comment								= CommentModel::get_instance();
		$this->MoodSay								= MoodSayModel::get_instance();
		$this->ISay									= ISayModel::get_instance();
		$this->SiteInfo								= SiteInfoModel::get_instance();
		$this->GXEngien	 							= new GXEngien();
		$this->GXEngien->templates_dir 				= ROOT_PATH.CONTENT_FOLDER."/themes/".TPL_NAME."/";
		$this->GXEngien->cache			   			= CACHE;
		$this->GXEngien->cache_life					= CACHE_LIFE;
		$this->GXEngien->cache_dir			   		= ROOT_PATH.SYSTEM_FOLDER.'/cache/';
		$this->GXEngien->cache_filename				= 'index.cache';
		$this->Cache								= new Cache($this->GXEngien);
		$this->TF									= new TextFilter();
		$this->GXPlugin								= GXPlugin::get_instance();
		ObjectManager::set_object(ObjectManager::TemplateActionGXEngien, $this->GXEngien);
		ObjectManager::set_object(ObjectManager::TemplateActionCache, $this->Cache);
	}
	
	/**
	 * 
	 * 重写接口
	 */
	/**
	 * Show Home Index Page
	 * 
	 * @since Alpha 0.0.1
	 * @access protected
	 */
	abstract protected function show_index();
	
	/**
	 * Generate Home Index Page
	 * 
	 * @since Alpha 0.1.0
	 * @access protected
	 */
	abstract protected function generate_index();
	
	/**
	 * Generate Tag Page
	 * 
	 * @since Alpha 0.1.0
	 * @access protected
	 */
	abstract protected function show_tag($tag);
	
	/**
	 * Generate Tag Page
	 * 
	 * @since Alpha 0.1.0
	 * @access protected
	 */
	abstract protected function generate_tag($tag);
	
	/**
	 * Generate Archive Page
	 * 
	 * @since Alpha 0.1.0
	 * @access protected
	 */
	abstract protected function generate_archive($p);

	/**
	 * Generate Archive Page
	 * 
	 * @since Alpha 0.1.0
	 * @access protected
	 */
	abstract protected function show_archive($p);
	
	abstract protected function show_404();
	
	/**
	 * 
	 * 模板引擎接口
	 */
	protected function dispose_filename($filename){
		$this->GXEngien->dispose_filename($filename);
	}
	
	protected function assign($tag,$value,$dim = NULL){
		$this->GXEngien->assign($tag,$value,$dim);
	}
	
	protected function del_section($tag){
		$this->GXEngien->del_section($tag);
	}
	
	protected function del_specific_content($tag){
		$this->GXEngien->del_specific_content($tag);
	}
	
	protected function show_static_html($filepath,$filename){
		$this->GXEngien->show_static_html($filepath,$filename);
	}
	
	protected function generate_static_html($filepath,$filename){
		$this->GXEngien->generate_static_html($filepath,$filename);
	}
	
	protected function display(){
		$this->GXEngien->display();
	}
	
	/**
	 * 
	 * SiteInfoModel 接口
	 */
	protected function web_name(){
		return $this->SiteInfo->get_web_name();
	}
	
	protected function web_desc(){
		return $this->SiteInfo->get_web_desc();
	}
	
	protected function web_statement(){
		return $this->SiteInfo->get_web_statement();
	}
	
	protected function web_link(){
		return $this->SiteInfo->get_web_link();
	}
	
	protected function name(){
		return $this->SiteInfo->get_name();
	}
	
	protected function email(){
		return $this->SiteInfo->get_email();
	}
	
	protected function qq(){
		return $this->SiteInfo->get_qq();
	}
	
	protected function web_record(){
		return $this->SiteInfo->get_web_record();
	}
	
	protected function web_copyright(){
		return $this->SiteInfo->get_web_copyright();
	}
	
	/**
	 * 
	 * ArticleModel 接口
	 */
	protected function get_articles($num = NULL){
		return $this->Article->get_articles($num);
	}	
	
	protected function get_random_articles($num = NULL){
		return $this->Article->get_random_articles($num);
	}
	
	protected function get_tags($num = NULL){
		return $this->Article->get_tags($num);
	}
	
	protected function get_articles_by_tag($tag,$num = NULL){
		return $this->Article->get_articles_by_tag($tag,$num);
	}
	
	protected function get_article_link($id){
		return $this->Article->get_article_link($id);
	}
	
	protected function get_article_name($id){
		return $this->Article->get_article_name($id);
	}
	
	protected function get_article_title($id){
		return $this->Article->get_article_title($id);
	}
	
	protected function get_article_time($id){
		return $this->Article->get_article_time($id);
	}
	
	protected function get_article_content($id){
		return $this->Article->get_article_content($id);
	}
	
	protected function get_article_tags($id){
		return $this->Article->get_article_tags($id);
	}
	
	protected function get_tag_link($tag){
		return $this->Article->get_tag_link($tag);
	}
	
	/**
	 * 
	 * CommentModel 接口
	 */
	protected function get_comments($num = NULL){
		return $this->Comment->get_comments($num);
	}
	
	protected function get_article_comments($id){
		return $this->Comment->get_article_comments($id);
	}
	
	/**
	 * 
	 * ISayModel 接口
	 */
	protected function get_isays($num = NULL){
		return $this->ISay->get_isays($num);
	}
	
	/**
	 * 
	 * MoodSayModel 接口
	 */
	protected function get_moodsays($num = NULL){
		return $this->MoodSay->get_moodsays($num);
	}

	/**
	 * TextFilter 接口
	 */
	protected function get_article_content_abstract($content){
		return $this->TF->get_article_abstract($content);
	}
	
	protected function get_article_content_desc($content){
		$content = $this->TF->get_article_abstract($content);
		return $this->TF->filter_article_abstract($content);
	}
	
	/**
	 * GXPlugin 接口
	 */
	protected function trigger($hock){
		
		$args = array_slice(func_get_args(), 0);
					
		$result = call_user_func_array(array($this->GXPlugin, 'trigger'), $args);

		return $result;
	}
}