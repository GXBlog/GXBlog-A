<?php
/**
 * Model Theme Functions
 * 
 * 主题扩展函数库
 * 
 * @author GenialX
 * @since Alpha 0.1.0
 */

/**
 *
 * GXTEMPLATE API
 */

/**
 * Require the header template file
 * 
 * @see GXTemplate::get_header()
 * @since Alpha 0.1.0
 * @uses $gx_template
 */
function get_header($name = NULL){
	global $gx_template;
	$gx_template->get_header($name);
}

/**
 * Require the sidebar template file
 * 
 * @see GXTemplate::get_sidebar()
 * @since Alpha 0.1.0
 * @uses $gx_template
 */
function get_sidebar($name = NULL){
	global $gx_template;
	$gx_template->get_sidebar($name);
}

/**
 * Require the footer template file
 * 
 * @see GXTemplate::get_footer()
 * @since Alpha 0.1.0
 * @uses $gx_template
 */
function get_footer($name = NULL){
	global $gx_template;
	$gx_template->get_footer($name);
}

/**
 * Require the specific template file
 * 
 * @see GXTemplate::get_template_part($slug,$name)
 * @since Alpha 0.1.0
 * @uses $gx_template
 */
function get_template_part($slug, $name = NULL){
	global $gx_template;
	$gx_template->get_template_part($slug,$name);
}

/**
 * 
 * GXQUERY API
 */

/**
 * Whether there are more posts or not
 * 
 * @see GXQuery::have_posts()
 * @since Alpha 0.1.0
 * @uses $gx_query
 * 
 * @return bool True if there are more posts, Flase or not
 */
function have_posts(){
	global $gx_query;
	return $gx_query->have_posts();
}

/**
 * Slice to the next post and set global $post
 * 
 * @see GXQuery::the_post()
 * @since Alpha 0.1.0
 * @uses $gx_query
 */
function the_post(){
	global $gx_query;
	$gx_query->the_post();
}

/**
 * Whether there are more comments or not
 * 
 * @see GXQuery::have_comments()
 * @since Alpha 0.1.0
 * @uses $gx_query
 * 
 * @return bool True if there are more comments, Flase or not
 */
function have_comments(){
	global $gx_query;
	return $gx_query->have_comments();
}

/**
 * Slice to the next comment and set global $comment
 * 
 * @see GXQuery::the_comment()
 * @since Alpha 0.1.0
 * @uses $gx_query
 */
function the_comment(){
	global $gx_query;
	$gx_query->the_comment();
}

/**
 * 
 * EACH POST API
 */

/**
 * Put the article (int)id of current post
 * 
 * @since Alpha 0.1.0
 * @uses $post
 */
function the_id(){
	global $post;
	echo $post['id'];
}

/**
 * Put the article (string)name of current post
 * 
 * @since Alpha 0.1.0
 * @uses $post
 */
function the_name(){
	global $post;
	echo $post['name'];
}

/**
 * Put the article (string)title of current post
 * 
 * @since Alpha 0.1.0
 * @uses $post
 */
function the_title(){
	global $post;
	echo $post['title'];
}

/**
 * Put the article (string)content of current post
 * 
 * @since Alpha 0.1.0
 * @uses $post
 */
function the_content(){
	global $post;
	echo $post['content'];
}
/**
 * Put the abstract article (string)content of current post
 * 
 * @since Alpha 0.1.0
 * @uses $post
 */
function the_abstract_content(){
	global $post, $text_filter;
	echo $text_filter->get_article_abstract($post['content']);
}

/**
 * Put the article (string)time of current post
 * 
 * @since Alpha 0.1.0
 * @uses $post
 */
function the_time(){
	global $post;
	echo $post['time'];
}

/**
 * Put the article (string)tags of current post
 * 
 * @since Alpha 0.1.0
 * @uses $post
 */
function the_tags(){
	global $post;
	echo $post['tags'];
}

/**
 * Put the article (int)comment count of current post
 * 
 * @since Alpha 0.1.0
 * @uses $post
 */
function the_comment_count(){
	global $post;
	echo $post['comment'];
}

/**
 * Put the article (int)like count of current post
 * 
 * @since Alpha 0.1.0
 * @uses $post
 */
function the_like_count(){
	global $post;
	echo $post['like'];
}

/**
 * Put the article link
 * 
 * @since Alpha 0.1.0
 * @uses $post, ArticleModel
 */
function the_link(){
	global $article_model, $post;
	echo $article_model->get_article_link($post['id']);
}

/**
 * Put the comment name
 * 
 * @since Alpha 0.1.0
 * @uses $comment
 */
function the_comment_name(){
	global $comment;
	echo $comment['name'];
}

/**
 * Put the comment time
 * 
 * @since Alpha 0.1.0
 * @uses $comment
 */
function the_comment_time(){
	global $comment;
	echo $comment['time'];
}

/**
 * Put the comment qq
 * 
 * @since Alpha 0.1.0
 * @uses $comment
 */
function the_comment_qq(){
	global $comment;
	echo $comment['qq'];
}

/**
 * Put the comment qq
 * 
 * @since Alpha 0.1.0
 * @uses $comment
 */
function the_comment_homepage(){
	global $comment;
	echo $comment['homepage'];
}

/**
 * Put the comment qq
 * 
 * @since Alpha 0.1.0
 * @uses $comment
 */
function the_comment_content(){
	global $comment;
	echo $comment['content'];
}


/**
 * SITE INFO API
 */

/**
 * put the site title
 * 
 * @since Alpha 0.1.0
 * @uses SiteInfoModel
 */
function site_title(){
	global $site_model;
	echo $site_model->get_web_name();
	
}

/**
 * put the site absolute path end with slice
 * 
 * @since Alpha 0.1.0
 */
function site_link(){
	echo HOME_PATH;
}

/**
 * put the site description
 * 
 * @since Alpha 0.1.0
 * @uses SiteInfoModel
 */
function site_desc(){
	global $site_model;
	echo $site_model->get_web_desc();
}

/**
 * put the site statement
 * 
 * @since Alpha 0.1.0
 * @uses SiteInfoModel
 */
function site_statement(){
	global $site_model;
	echo $site_model->get_web_statement();
}


/**
 * put the site author
 * 
 * @since Alpha 0.1.0
 * @uses SiteInfoModel
 */
function site_author(){
	global $site_model;
	echo $site_model->get_name();
}

/**
 * put the site email
 * 
 * @since Alpha 0.1.0
 * @uses SiteInfoModel
 */
function site_email(){
	global $site_model;
	echo $site_model->get_email();
}

/**
 * put the site qq
 * 
 * @since Alpha 0.1.0
 * @uses SiteInfoModel
 */
function site_qq(){
	global $site_model;
	echo $site_model->get_qq();
}

/**
 * put the site record
 * 
 * @since Alpha 0.1.0
 * @uses SiteInfoModel
 */
function site_record(){
	global $site_model;
	echo $site_model->get_web_record();
}

/**
 * put the site copyright
 * 
 * @since Alpha 0.1.0
 * @uses SiteInfoModel
 */
function site_copyright(){
	global $site_model;
	echo $site_model->get_web_copyright();
}

/**
 * ARTICLE API
 */

/**
 * Article Tags
 * 
 * @since Alpha 0.1.0
 * @uses ArticleModel
 * 
 * @return array
 */
function get_article_tags(){
	global $article_model;
	$rows = $article_model->get_tags();
	$tags = array();
	$tag = array();
	if($rows){
		foreach ($rows as $result){
			array_push($tags, explode(',', $result['tags']));
		}
		
		foreach($tags as $result ){
			if( ! in_array($result[0], $tag)){
				array_push($tag,$result[0]);
			}
		}
	}
	return $tag;
}

/**
 * the Specific Article Tags
 * 
 * @since Alpha 0.1.0
 * @uses ArticleModel
 */
function article_tag($id){
	global $article_model;
	$tags = null;
	
	$tags = $article_model->get_article_tags($id);
	
	echo $tags;
}

/**
 * 
 * Article Title
 * @param $id article_id
 * 
 * @since Alpha 0.1.0
 * @uses ArticleModel
 */
function article_title($id){
	global $article_model;
	echo $article_model->get_article_title($id);
}


/**
 * the Specific Article Content
 * 
 * @param $id article_id
 * 
 * @since Alpha 0.1.0
 * @uses ArticleModel
 */
function article_content($id){
	global $article_model;
	echo $article_model->get_article_content($id);
	
}

/**
 * the Specific Article Abstract Content
 * 
 * @param int $id article_id
 * 
 * @since Alpha 0.1.0
 * @uses ArticleModel
 */
function article_abstract_content($id){
	global $article_model,$text_filter;
	echo $text_filter->get_article_abstract($article_model->get_article_content($id));
}

/**
 * Put the Specific Article's Link
 * 
 * @param int $id article's id
 * 
 * @since Alpha 0.1.0
 * @uses ArticleModel
 */
function article_link($id){
	global $article_model;
	$link = $article_model->get_article_link($id);
	echo $link;	
}

/**
 * Return Some Articles
 * 
 * @param int $num article count
 * 
 * @since Alpha 0.1.0
 * @uses ArticleModel
 * 
 * @return array - tow rows
 */
function get_articles($num){
	global $article_model;
	return $article_model->get_articles($num);
}

/**
 * Return Random Articles
 * 
 * @param int $num article count
 * 
 * @since Alpha 0.1.0
 * @uses ArticleModel
 * 
 * @return array - two rows
 */
function get_random_articles($num){
	global $article_model;
	return $article_model->get_random_articles($num);
}

/**
 * Put the Specific Article's time
 * 
 * @param int $id article's id
 * 
 * @since Alpha 0.1.0
 * @uses ArticleModel
 * 
 * @return array - two rows
 */
function article_time($id){
	global $article_model;
	echo $article_model->get_article_time($id);
}

/**
 * Put the Specific Article's comment count
 * 
 * @param int $id article's id
 * 
 * @since Alpha 0.1.0
 * @uses ArticleModel
 */
function article_comment_count($id){
	global $article_model;
	echo $article_model->get_article_comment($id);
}

/**
 * Put the Specific Article's like count
 * 
 * @param int $id article's id
 * 
 * @since Alpha 0.1.0
 * @uses ArticleModel
 */
function article_like_count($id){
	global $article_model;
	echo $article_model->get_article_like($id);
}

/**
 * Put the Specific Tag's link
 * 
 * @param int $id article's id
 * 
 * @since Alpha 0.1.0
 * @uses ArticleModel
 */
function tag_link($tag){
	global $article_model;
	echo $article_model->get_tag_link($tag);
}


/**
 * Comment API
 */

/**
 * Put the Specific Article's Link
 * 
 * @param int $id article's id
 * 
 * @since Alpha 0.1.0
 * @uses ArticleModel
 * 
 * @return array - two rows
 */
function get_comments($num){
	global $comment_model;
	return $comment_model->get_comments($num);
}

/**
 * Put the Specific Article's Link
 * 
 * @param int $id article's id
 * 
 * @since Alpha 0.1.0
 * @uses ArticleModel
 *
 * @return array - two rows
 */
function get_article_comments($id){
	global $comment_model;
	return $comment_model->get_article_comments($id);
}

/**
 * Plugin API
 */

/**
 * Activate The Specific Hoop
 * 
 * @since Alpha 0.1.0
 * @uses GXPlugin
 * 
 * @return String $result
 */
function trigger($hoop){
	global $gxplugin;
	
	$args = array_slice(func_get_args(), 0);
					
	$result = call_user_func_array(array($gxplugin, 'trigger'), $args);

	return $result;
}