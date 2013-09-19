<?php
class TrueStaticTagLink extends StaticArticleLink{
	public function get_link($tag){
		return HOME_PATH.'tag/'.$tag.'/';
	}
}