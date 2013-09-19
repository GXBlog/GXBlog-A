<?php
/**
 * 用最简单的方式，展现自己的个性
 */
class TemplateAction extends ShowActionAdapter{
	
	/********************************************/
	/*********		       重写函数段			*********/
	/********************************************/
	
	public function generate_index(){

		$this->dispose_filename('index.html');
		
		//HOMEPATH
		$this->assign('site_path',HOME_PATH);
		$this->assign('site_search',HOME_PATH);
		
		//SITE INFO
		$this->assign('title',$this->web_name().' - '.$this->web_desc());
		$this->assign('logo',$this->web_name());
		$this->assign('web_desc',$this->web_desc());
		$this->assign('keywords', $this->web_name().' - '.$this->web_desc());
		$this->assign('description',$this->web_desc());
		
		//ISAY
		$rows = $this->get_isays(10);
		if($rows){
			foreach ($rows as $value){
				$isay[] = array("content"=>$value['content'],"time"=>$value['time']);
			}
			$this->assign('iSay',$isay);
		}else{
			$this->del_section('iSay');
		}
		
		//TAG WALL
		$rows = $this->get_tags();
		$articleTags = array();
		$tags = array();
		if($rows){
			foreach ($rows as $result){
				array_push($tags, explode(',', $result['tags']));
			}
			foreach ($tags as $tag){
				foreach ($tag as $t){
					$link = $this->get_tag_link($t);
					if (!in_array(array('tag'=>$t,'link'=>$link),$articleTags)) {
  						$articleTags[] = array('tag'=>$t,'link'=>$link);
					}
				}
			}
			
			$this->assign("articleTags",$articleTags);
		}else{
			$this->del_section('articleTags');
		}
		
		//RANDOM ARTICLE
		$rows = $this->get_random_articles(20);
		if($rows){
			$rearticles = array();
			foreach ($rows as $value){
				$link = $this->get_article_link($value['id']);
				$rearticles[] = array("link"=>$link,"title"=>$value['title']);
			}
			$this->assign('rearticles', $rearticles); 
		}else{
			$this->del_section('rearticles');
		}
		
		//ARTICLES
		$articles = array();
		$rows = $this->get_articles(20);
		if($rows){
			foreach ($rows as $value){
				$link = $this->get_article_link($value['id']);
				$tagsArray = explode(",",$value['tags']);
				$tags = array();
				for($i=0;$i<count($tagsArray);$i++){
					array_push($tags,$tagsArray[$i]);
				}
				
				$value['content'] = $this->get_article_content_abstract($value['content']);
				
				$articles[] = array("id"=>$value['id'],"title"=>$value['title'],
								"content"=>$value['content'],"time"=>$value['time'],
								"like"=>$value['like'],"comment"=>$value['comment'],
								"tags"=>$tags,"link"=>$link,"title_id"=>$value['id']);
			}
			$this->assign('articles',$articles,3);
		}else{
			$this->del_section('articles');
		}
		
		//ME IMG
		$me_img = "me_".rand(1, 1);
		$this->assign("me_img",$me_img);
		
		//MOOD SAY
		$rows = $this->get_moodsays(10);
		if($rows){
		$moodsay = array();
			foreach ($rows as $value){
				$moodsay[] = array("content"=>$value['content']);
			}
			$this->assign("moodsay",$moodsay);
		}else{
			$this->del_section('moodsay');
		}
		
		//COMMENT
		$rows = $this->get_comments(10);
		if($rows){
			$newArticleComments = array();
			foreach ($rows as $value){
				$link = $this->get_article_link($value['article_id']);
				$link .= "#comments-".$value['id'];
				$newArticleComments[] = array("content"=>$value['content'],"time"=>$value['time'],
												"name"=>$value['name'],"link"=>$link);	
			}
			$this->assign("newArticleComments",$newArticleComments);
		}else{
			$this->del_section('newArticleComments');
		}
				
		//SITE FOOTER
		$this->assign('web_name',$this->web_name());
		$this->assign('web_copyright',$this->web_copyright());
		$this->assign('web_record',$this->web_record());
		
		//GENERATE HTML
		$this->generate_index_cache();
	}
	
	public function generate_archive($p){
		
		$id = $p;
		
		$this->dispose_filename('archive.html');
			
		//HOMEPATH
		$this->assign('site_path',HOME_PATH);
		$this->assign('article_link', $this->get_article_link($id));
		$this->assign('site_search',HOME_PATH);
		
		//SITE INFO
		$this->assign('title',$this->get_article_title($id).' - '.$this->web_name());
		$this->assign('logo',$this->get_article_title($id));
		$this->assign('web_name',$this->web_name());
		$this->assign('keywords',$this->get_article_title($id).' - '.$this->get_article_tags($id));
		$this->assign('description',$this->get_article_title($id));
		
		//ARTICLE
		$this->assign('article_title',$this->get_article_title($id));
		$this->assign('article_time',$this->get_article_time($id));
		$this->assign('article_content',$this->get_article_content($id));
		
		$result = $this->get_article_tags($id);
		$tags = array();
		if($result != FALSE){
			$tags = explode(",",$result);
		}
		unset($result);
		$this->assign('article_tags',$tags);
		
		//TAG WALL
		$rows = $this->get_tags();
		$articleTags = array();
		$tags = array();
		if($rows){
			foreach ($rows as $result){
				array_push($tags, explode(',', $result['tags']));
			}
			foreach ($tags as $tag){
				foreach ($tag as $t){
					$link = $this->get_tag_link($t);
					if (!in_array(array('tag'=>$t,'link'=>$link),$articleTags)) {
  						$articleTags[] = array('tag'=>$t,'link'=>$link);
					}
				}
			}
			
			$this->assign("articleTags",$articleTags);
		}else{
			$this->del_section('articleTags');
		}
		
		//RANDOM ARTICLE
		$rows = $this->get_random_articles(20);
		if($rows){
			$rearticles = array();
			foreach ($rows as $value){
				$link = $this->get_article_link($value['id']);
				$rearticles[] = array("link"=>$link,"title"=>$value['title']);
			}
			$this->assign('rearticles', $rearticles); 
		}else{
			$this->del_section('rearticles');
		}
	
		//MOOD SAY
		$rows = $this->get_moodsays(10);
		if($rows){
		$moodsay = array();
			foreach ($rows as $value){
				$moodsay[] = array("content"=>$value['content']);
			}
			$this->assign("moodsay",$moodsay);
		}else{
			$this->del_section('moodsay');
		}
		
		//COMMENT
		$rows = $this->get_article_comments($id);
		if($rows){
			$comments = array();
			foreach ($rows as $value){
				$comments[] = array("name"=>$value['name'],"qq"=>$value['qq'],"homepage"=>$value['homepage'],"time"=>$value['time'],"id"=>$value['id'],"content"=>$value['content']);
			}
			$this->assign("comments",$comments);
		}else{
			$this->del_section('comments');
		}

		//SITE FOOTER
		$this->assign('web_name',$this->web_name());
		$this->assign('web_copyright',$this->web_copyright());
		$this->assign('web_record',$this->web_record());
		
		//OTHERS
		$this->assign('article_id', $id);
		
		$this->trigger('SYNTAXHIGHLIGHTER_GENERATE');
		
		//GENERATE HTML
		$this->generate_archive_cache($p);
		
	}

	public function generate_tag($tag){
		
		$tag = $_GET['tag'];
		
		$this->dispose_filename('list.html');
			
		//HOMEPATH
		$this->assign('site_path',HOME_PATH);
		$this->assign('site_search',HOME_PATH);
		
		//SITE INFO
		$this->assign('title',$tag.' - '.$this->web_name());
		$this->assign('logo',$tag);
		$this->assign('web_name',$this->web_name());
		$this->assign('keywords',$tag);
		$this->assign('description',$tag);
		
		//TAG
		$this->assign('tag', $tag);
		
		//ARTICLES
		$articles = array();
		$rows = $this->get_articles_by_tag($tag);
		if($rows){
			foreach ($rows as $value){
				$link = $this->get_article_link($value['id']);
				$tagsArray = explode(",",$value['tags']);
				$tags = array();
				for($i=0;$i<count($tagsArray);$i++){
					array_push($tags,$tagsArray[$i]);
				}
				
				$value['content'] = $this->get_article_content_abstract($value['content']);
				
				$articles[] = array("id"=>$value['id'],"title"=>$value['title'],
								"content"=>$value['content'],"time"=>$value['time'],
								"like"=>$value['like'],"comment"=>$value['comment'],
								"tags"=>$tags,"link"=>$link,"title_id"=>$value['id']);
			}
			$this->assign('articles',$articles,3);
		}else{
			$this->del_section('articles');
		}
		
		//TAG WALL
		$rows = $this->get_tags();
		$articleTags = array();
		$tags = array();
		if($rows){
			foreach ($rows as $result){
				array_push($tags, explode(',', $result['tags']));
			}
			foreach ($tags as $tag){
				foreach ($tag as $t){
					$link = $this->get_tag_link($t);
					if (!in_array(array('tag'=>$t,'link'=>$link),$articleTags)) {
  						$articleTags[] = array('tag'=>$t,'link'=>$link);
					}
				}
			}
			
			$this->assign("articleTags",$articleTags);
		}else{
			$this->del_section('articleTags');
		}
		
		//RANDOM ARTICLE
		$rows = $this->get_random_articles(20);
		if($rows){
			$rearticles = array();
			foreach ($rows as $value){
				$link = $this->get_article_link($value['id']);
				$rearticles[] = array("link"=>$link,"title"=>$value['title']);
			}
			$this->assign('rearticles', $rearticles); 
		}else{
			$this->del_section('rearticles');
		}
		
		//MOOD SAY
		$rows = $this->get_moodsays(10);
		if($rows){
		$moodsay = array();
			foreach ($rows as $value){
				$moodsay[] = array("content"=>$value['content']);
			}
			$this->assign("moodsay",$moodsay);
		}else{
			$this->del_section('moodsay');
		}

		//SITE FOOTER
		$this->assign('web_name',$this->web_name());
		$this->assign('web_copyright',$this->web_copyright());
		$this->assign('web_record',$this->web_record());
		
		//GENERATE
		$this->generate_tag_cache($_GET['tag']);
		
	}
	
	/********************************************/
	/*********		 扩展函数段			*********/
	/********************************************/
	
	/**
	 * 
	 *过滤字符
	 * @param String $str
	 * @param String $mark
	 */
	public function filter_specific_mark($str,$mark){
		$str_replaced = null;
		$str_sub = null;
		$str_sub = explode($mark, $str);
		foreach ($str_sub as $key=>$value){
			$str_replaced .= $str_sub[$key];
		}
		return $str_replaced;	
	}
	
}
