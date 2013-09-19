<?php
/**
 * @name TextFilter 
 * @desc 文字过滤类，处理一些文字的实现。比如：字符串截取，过滤敏感字符...
 * @author GenialX
 * @version 0.1
 * @since 2013.05.11
 */

class TextFilter{
	
	/**  
	* 中文截取，支持gb2312,gbk,utf-8,big5  
	*  
	* @param string $str 要截取的字串  
	* @param int $start 截取起始位置  
	* @param int $length 截取长度  
	* @param string $charset utf-8|gb2312|gbk|big5 编码  
	* @param $suffix 是否加尾缀  
	*/
	 
	public function get_substr($str, $start=0, $length, $charset="utf-8", $suffix=true)  
	{  
	   if(function_exists("mb_substr"))  
	   {
	       if(mb_strlen($str, $charset) <= $length) return $str;  
	       
	       $length += 0.0;//转换为浮点型数据
	 
	       $slice = mb_substr($str, $start, $length, $charset);  
	   }
	   else
	   {  
	       $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";  
	       $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";  
	       $re['gbk']          = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";  
	       $re['big5']          = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";  
	       preg_match_all($re[$charset], $str, $match);  
	       if(count($match[0]) <= $length) return $str;
	       $slice = join("",array_slice($match[0], $start, $length));  
	   }
	   if($suffix) return $slice."......";  
	   return $slice;  
	} 
	
	
	
	/**
	 * 
	 * 将一个字符串中的内容的特定符号过滤掉
	 */
	public function filter_specific_mark($str,$mark){
		$str_replaced = null;
		$str_sub = null;//被拆分后的子数组
		$str_sub = explode($mark, $str);
		foreach ($str_sub as $key=>$value){
			$str_replaced .= $str_sub[$key];
		}
		return $str_replaced;	
	}
	
	/**
	 * 替换
	 * 把$mark_search换成$mark_replace
	 */
	public function article_content_replace($mark_search,$mark_replace,$str){
		$str = str_replace($mark_search, $mark_replace, $str);
		return $str;
	}
	
	/**
	 * 过滤掉提交信息中的敏感字符
	 * Enter description here ...
	 * @param unknown_type $str
	 */
	public function filter_post_info($str){
		$str = str_replace(" ","&nbsp;", $str);
		$str = str_replace("'","&#39;", $str);
		$str = str_replace("\"","&#34;", $str);
		$str = str_replace("<","&#60;",$str);
		$str = str_replace(">","&#62;",$str);
		return $str;
	}
	
	/**
	 * 过滤URL提交的‘tag’信息
	 * Enter description here ...
	 */
	public function filter_tag($str){
		$str = str_replace(" ","", $str);
		$str = str_replace("'","", $str);
		return $str;
	}
	
	/**
	 * 过滤文章显示再要的内容中的字符
	 * Enter description here ...
	 * @param unknown_type $str
	 */
	public function filter_article_abstract($str){
		$str = str_replace(" ","&nbsp;", $str);
		$str = str_replace("'","&#39;", $str);
		$str = str_replace("\"","&#34;", $str);
		$str = str_replace("<","&#60;",$str);
		$str = str_replace(">","&#62;",$str);
		return $str;
	}
	
	/**
	 * 获取文章摘要
	 * Enter description here ...
	 * @param unknown_type $str
	 * @param $marks 摘要分页的标志  默认为<!-- more -->
	 */
	public function get_article_abstract($str,$marks = NULL){
		
		if(!isset($marks)){
			$marks = "<!-- more -->";
		}
		
		if(!strpos($str, $marks)){
			$str = $this->get_substr($str,0,512);
			return $str;
		}
		$length = strpos($str, $marks);
		$str = substr($str, 0,$length);
		$str .= "......";
		return $str;
	}
	
	public function filter_article_content_post($str){
		$str = str_replace("'","&#39;", $str);
		return $str;
	}
}