<?php
class FalseStaticArticleLink extends StaticArticleLink{
	public function get_link($id){
		return HOME_PATH.'?p='.$id;
	}
}