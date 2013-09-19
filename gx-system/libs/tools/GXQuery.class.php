<?php
/**
 * GXBlog Query API
 * 
 * 用于处理复杂的请求GXBlog博客中文章或页面的类。
 * 
 * @author GenialX
 * @since Alpha 0.1.0
 *
 */
class GXQuery{
	
	/**
	 * Query vars set by the user
	 *
	 * @since Alpha 0.1.0
	 * @access private
	 * @var array|string
	 */
	private $query;

	/**
	 * Query vars, after parsing
	 *
	 * @since Alpha 0.1.0
	 * @access private
	 * @var array
	 */
	private $query_vars = array();

	/**
	 * List of posts.
	 *
	 * @since Alpha 0.1.0
	 * @access private
	 * @var array
	 */
	private $posts;

	/**
	 * The amount of posts for the current query.
	 *
	 * @since Alpha 0.1.0
	 * @access private
	 * @var int
	 */
	private $post_count = 0;

	/**
	 * Index of the current item in the loop.
	 *
	 * @since Alpha 0.1.0
	 * @access private
	 * @var int
	 */
	private $current_post = -1;

	/**
	 * The current post ID.
	 *
	 * @since Alpha 0.1.0
	 * @access private
	 * @var array
	 */
	private $post;
	
	/**
	 * List of comments.
	 *
	 * @since Alpha 0.1.0
	 * @access private
	 * @var array
	 */
	private $comments;

	/**
	 * The amount of comments for the current query.
	 *
	 * @since Alpha 0.1.0
	 * @access private
	 * @var int
	 */
	private $comment_count = 0;

	/**
	 * Index of the current item in the loop.
	 *
	 * @since Alpha 0.1.0
	 * @access private
	 * @var int
	 */
	private $current_comment = -1;

	/**
	 * The current post ID.
	 *
	 * @since Alpha 0.1.0
	 * @access private
	 * @var array
	 */
	private $comment;
	
	
	/**
	 * Constructor.
	 *
	 * Sets up the GXBlog query, if parameter is not empty.
	 *
	 * @since Alpha 0.1.0
	 * @access public
	 *
	 * @param string $query URL query string.
	 */
	public function __construct($query = NULL) {
		$this->query($query);
	}
	
	/**
	 * Sets up the GXBlog query by parsing query string.
	 *
	 * @since Alpha 0.1.0
	 * @access private
	 *
	 * @param array $query URL query array.
	 * @return array List of posts.
	 */
	private function query( $query ) {
		$this->init();
		$this->query = $query;
		$this->parse_args( $query );
		$this->get_posts();
	}
		
	/**
	 * Initiates object properties and sets default values.
	 *
	 * @since Alpha 0.1.0
	 * @access private
	 */
	private function init(){
		unset($this->posts);
		unset($this->comments);
		unset($this->query);
		$this->query_vars = array();
		$this->post_count = 0;
		$this->comment_count = 0;
		$this->current_post = -1;
		$this->current_comment = -1;
		unset( $this->post );
		unset( $this->comment );
	}
	
	/**
	 * 
	 * Get post datas.
	 * 
	 * @since Alpha 0.1.0
	 * @access private
	 * 
	 */
	private function get_posts(){
		$Article = ArticleModel::get_instance();
		if( ! empty($this->query_vars['tag']) ){
			if( ( $this->posts = $Article->get_articles_by_tag($this->query_vars['tag']) ) ) {
				$this->post_count = count($this->posts);
			}else{
				//...
			}
		}else if(! empty($this->query_vars['p'])){
			$require[0] = array('id'=>$this->query_vars['p']);
			$sqlRequire = new SingleSqlRequire($require);
			if( ( $this->posts = $Article->get_articles(NULL,$sqlRequire) ) ) {
				$this->post_count = count($this->posts);
			}else{
				//...
			}
		}else{
			if( ( $this->posts = $Article->get_articles(20) ) ){
				$this->post_count = count($this->posts);
			}else{
				//...
			}
		}
	}
		
	/**
	 * 
	 * Get comments datas.
	 * 
	 * @since Alpha 0.1.0
	 * @access private
	 * 
	 */
	private function get_comments(){
		
		$Comment = CommentModel::get_instance();
		
		$this->comments = $Comment->get_article_comments($_GET['p']);
		
		if($this->comments == false) {
			unset($this->comments);
			$this->comment_count = 0;
			return;
		}
		
		$this->comment_count = count($this->comments);
	}
	
	/**
	 * Parse a query string and set query type booleans.
	 *
	 * @since Alpha 0.1.0
	 * @access private
	 *
	 * @param string|array $query Optional query.
	 */
	private function parse_args($query){
		
		if(is_null($query)){
			$this->query_vars['tag'] = '';
			$this->query_vars['p'] = '';
			return;
		}
		
		if(isset($query['tag'])){
			$this->query_vars['tag'] = $this->query['tag'];
			$this->query_vars['p'] = '';
			return;
		}
		
		if(isset($query['p'])){
			$this->query_vars['p'] = $this->query['p'];
			$this->query_vars['tag'] = '';
			$this->get_comments();
			return;
		}
		
	}
	
	/**
	 * Whether there are more posts available in the loop.
	 *
	 * @since Alpha 0.1.0
	 * @access public
	 *
	 * @return bool True if posts are available, false if end of loop.
	 */
	public function have_posts(){
		if ( $this->current_post + 1 < $this->post_count ) {
			return true;
		} elseif ( $this->current_post + 1 == $this->post_count && $this->post_count > 0 ) {
			// Do some cleaning up after the loop
			$this->rewind_posts();
		}
		return false;
	}
	
	/**
	 * 
	 * Get current post and set global var $post
	 * 
	 * @since Alpha 0.1.0
	 * @access public
	 */
	public function the_post(){
		global $post;
		$this->post = $this->next_post();
		$post = $this->post;
	}
	
	/**
	 * Set up the next post and iterate current post index.
	 *
	 * @since Alpha 0.1.0
	 * @access private
	 *
	 * @return Next post.
	 */
	private function next_post(){
		$this->current_post++;
		return $this->posts[$this->current_post];
	}
	
	/**
	 * Rewind the posts and reset post index.
	 *
	 * @since Alpha 0.1.0
	 * @access private
	 */
	private function rewind_posts(){
		$this->current_post = -1;
		if ( $this->post_count > 0 ) {
			$this->post = $this->posts[0];
		}
	}
	
	/**
	 * Whether there are more comments available in the loop.
	 *
	 * @since Alpha 0.1.0
	 * @access public
	 *
	 * @return bool True if comments are available, false if end of loop.
	 */
	public function have_comments(){
		if ( $this->current_comment + 1 < $this->comment_count ) {
			return true;
		} elseif ( $this->current_comment + 1 == $this->comment_count && $this->comment_count > 0 ) {
			// Do some cleaning up after the loop
			$this->rewind_comments();
		}
		return false;
	}
	
	
	/**
	 * 
	 * Get current comment and set global var $comment
	 * 
	 * @since Alpha 0.1.0
	 * @access public
	 */
	public function the_comment(){
		global $comment;
		$this->comment = $this->next_comment();
		$comment = $this->comment;
	}
	
	/**
	 * Set up the next comment and iterate current comment index.
	 *
	 * @since Alpha 0.1.0
	 * @access private
	 *
	 * @return Next comment.
	 */
	private function next_comment(){
		$this->current_comment++;
		return $this->comments[$this->current_comment];
	}
	
	/**
	 * Rewind the comments and reset comment index.
	 *
	 * @since Alpha 0.1.0
	 * @access private
	 */
	private function rewind_comments(){
		$this->current_comment = -1;
		if ( $this->comment_count > 0 ) {
			$this->comment = $this->comments[0];
		}
	}
	
}