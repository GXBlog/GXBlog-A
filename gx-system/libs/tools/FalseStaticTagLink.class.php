<?php
class FalseStaticTagLink extends StaticArticleLink{
	public function get_link($tag){
		return HOME_PATH.'?tag='.$tag;
	}
}