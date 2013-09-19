<?php
class TrueStaticArticleLink extends StaticArticleLink{
	
	public function get_link($id){
		
		/**
		 *
		 * Alpha 0.0.1
		
		$TextFilter = new TextFilter();
		$Article 	= ArticleModel::get_instance();
		
		$require[0] = array('id'=>$id);
	
		$SingleSqlRequire = new SingleSqlRequire($require);
		
		$rows = $Article->get_articles(NULL,$SingleSqlRequire);
		
		
		if($rows == FALSE){
			return FALSE;
		}
		
		foreach ($rows as $value){
			$link = $value['time'].".html";
			$link = $TextFilter->filter_specific_mark($link," ");
			$link = $TextFilter->filter_specific_mark($link,"-");
			$link = $TextFilter->filter_specific_mark($link,":");
			$link = HOME_PATH ."archives/".$link;
		}
		*/
		
		$link = HOME_PATH . 'p/' . $id . '.html';
		
		return $link;
	}
}