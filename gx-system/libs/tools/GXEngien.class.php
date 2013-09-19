<?php
/**
 * @name GXEngien
 * @desc 模板引擎 - 模板替换、生成静态页
 * @author GenialX
 * @version 0.1
 * @since 2013.05.10
 */

class GXEngien{
	public $tag_left_name 			= '{';//预处理标签左标志 	
	public $tag_right_name 			= '}';//预处理标签右标志
	public $templates_dir 			= NULL;//模板所处的路径
	public $cache 					= FALSE;//缓存功能，默认关闭
	public $cache_life				= 600;//模板刷新周期
	public $cache_dir				= NULL;
	public $cache_filename			= NULL;
	
	private $tags 					= array();//预处理的标签
	private $values 				= array();//预处理的变量内容
	private $template_content		= NULL;//临时输出模板的内容
	private $dispose_filename 		= NULL;//预处理模板的文件名字
	
	/**
	 * @desc 构造函数
	 * 初始化，引入模板文件
	 */
	public function __construct(){
	}
	
	/**
	 * @desc 解析函数
	 * Enter description here ...
	 */
	public function __destruct(){
		$this->tags 				= NULL;
		$this->values 				= NULL;
		$this->template_content 	= NULL;
	}
	
	/**
	 * 
	 * 指定要处理文件的名字
	 */
	public function dispose_filename($filename){
		$this->dispose_filename = $filename;
		$filename = $this->templates_dir.$filename;
		if(!file_exists($filename)){
			die("The template file ".$filename."is not exists!");
		}else{
			//输出模板文件内容到内存变量
			$this->template_content = file_get_contents($filename);	
		}
	}
	
	/**
	 * 
	 * 将预处理的标签和内容放入到内存变量中
	 * @param unknown_type $tag_name
	 * @param unknown_type $val
	 */
	public function assign($tag_name,$val,$dim = NULL){
		
		if( isset($dim) && $dim == 1){
			return;
		}else if(isset($dim) && $dim == 2){
			return;
		}else if(isset($dim) && $dim == 3){
			$this->assign_3dim_array($tag_name,$val);
			return;
		}
		
		if($this->get_array_dim($val) == 1){//一维数组的处理	
			$this->assign_1dim_array($tag_name,$val);	
		}elseif($this->get_array_dim($val) == 2){//二维数组的处理
			$this->assign_2dim_array($tag_name,$val);
		}elseif($this->get_array_dim($val) == 0){//单变量的处理
			array_push($this->tags,$this->tag_left_name."$".$tag_name.$this->tag_right_name);
			array_push($this->values,$val);	
		}
	}
	
	/**
	 * 
	 * 一维数组的处理实现
	 * @param unknown_type $tag_name
	 * @param unknown_type $val
	 */
private function assign_1dim_array($tag_name,$val,$template_content = NULL){
		/** 变量定义处 */
		$foreach_start 					= 0;//循环块开始的位置
		$foreach_end 					= 0;//循环块结束的位置
		$foreach_content 				= null;//存放循环块内容的变量
		$template_content_length 		= 0;//$this->template_content的长度
		$tag_name_length 				= strlen($tag_name);//标签名字的长度，比如$testtag，其长度为7（不包括$符号）
		$foreach_content_start 			= 0;//html标签起始位置
		$foreach_content_end 			= 0;//html标签结束位置
		$foreach_content_replaced 		= null;//循环块中html被循环替换后的内容
		$template_content_replaced 		= null;
		$is_template_content 			= false;//标志是否给$template_content赋值的开关
		
		if(isset($template_content)){
			$is_template_content = true;
		}else{
			$template_content = $this->template_content;
		}
		
		/** 取得模板中对应的一维循环快并去掉foreach标签 */
	    $foreach_start=strpos($template_content,$this->tag_left_name.'foreach=$'.$tag_name.$this->tag_right_name);
 	    $foreach_end=strpos($template_content,$this->tag_left_name.'/foreach'.$this->tag_right_name);
 	    $foreach_end = $foreach_end+10;
 	    $foreach_content=substr($template_content,$foreach_start,$foreach_end-$foreach_start);//取得循环块
		//将一维循环快其中的{foreach}标签去掉
		$foreach_content_start = 11+$tag_name_length;
		$foreach_content_end = strpos($foreach_content, $this->tag_left_name.'/foreach'.$this->tag_right_name);
		$foreach_content_end = $foreach_content_end-1;
 		$foreach_content = substr($foreach_content,$foreach_content_start,$foreach_content_end - $foreach_content_start);
 		/** 对tag_foreach块进行处理  */
 		//解析变量。将变量存入数组中，并将循环块中的信息进行替换
		foreach($val as $key=>$value){
			//将变量的名字压入到内存数组中
			array_push($this->tags, $this->tag_left_name."$".$tag_name."[".$key."]".$this->tag_right_name);
			//将循环块中的一维标签进行替换，并将替换后的模板内容赋值给$foreach_content_replaced
			$foreach_content_replaced .= str_replace($this->tag_left_name."$".$tag_name.$this->tag_right_name, $this->tag_left_name."$".$tag_name."[".$key."]".$this->tag_right_name, $foreach_content);
			//将变量对应的内容压入到内存数组中
			array_push($this->values,$value);
		}
		/** 改变$template_content中的内容 */
		$template_content_length = strlen($template_content);
		$template_content_replaced = substr($template_content, 0,$foreach_start);
		$template_content_replaced .= $foreach_content_replaced;
		$template_content_replaced .= substr($template_content, $foreach_end+1,$template_content_length-$foreach_end-1);
		//将$template_content的内容进行替换
		if($is_template_content){
			return $template_content_replaced;
		}else{
			$this->template_content = $template_content_replaced;	
		}
	}
	
	private function assign_2dim_array($tag_name,$val){
		/** 定义变量处 */
		$section_start 					= 0;//循环块开始的位置
		$section_end 					= 0;//循环块结束的位置
		$section_content 				= null;//存放循环块内容的变量
		$template_content_length 		= 0;//$this->template_content的长度
		$tag_name_length 				= strlen($tag_name);//标签名字的长度，比如$testtag，其长度为7（不包括$符号）
		$section_content_start 			= 0;//html标签起始位置
		$section_content_end 			= 0;//html标签结束位置
		$section_content_replaced 		= null;//循环块中html被循环替换后的内容
		
		/** 取得模板中section块的内容 并去掉section标签*/
		$section_start=strpos($this->template_content,$this->tag_left_name.'section=$'.$tag_name.$this->tag_right_name);
		$section_end=strpos($this->template_content,$this->tag_left_name.'/section'.$this->tag_right_name);
 	    $section_end = $section_end+10;
 	    //取得循环块
 	    $section_content=substr($this->template_content,$section_start,$section_end-$section_start);
 	    //去掉section标签
 	    $section_content_start = 11+$tag_name_length;
		$section_content_end = strpos($section_content, $this->tag_left_name.'/section'.$this->tag_right_name);
		$section_content_end = $section_content_end-1;
 		$section_content = substr($section_content,$section_content_start,$section_content_end - $section_content_start);
 		/** 对块进行section循环处理 */
 		//$val = $this->get_new_array($val);
 		//解析变量。将变量存入数组中，并将循环块中的信息进行替换
 		$i = 0;

 		foreach($val as $key1=>$value1){

 			$section_content_replaced .= $section_content;
 			foreach($value1 as $key2=>$value2){	
		 		
 				//将变量的名字压入到内存数组中
				array_push($this->tags, $this->tag_left_name."$".$tag_name."[".$key1."][".$key2."]".$this->tag_right_name);
				//将循环块中的一维标签进行替换，并将替换后的模板内容赋值给$foreach_content_replaced
				$section_content_replaced = str_replace($this->tag_left_name."$".$tag_name."[".$key2."]".$this->tag_right_name, $this->tag_left_name."$".$tag_name."[".$key1."][".$key2."]".$this->tag_right_name, $section_content_replaced);
				//将变量对应的内容压入到内存数组中			
				array_push($this->values,$value2);
		 			
 			}
 		}
 		/** 改变$template_content中的内容 */
		$template_content_length 		= strlen($this->template_content);
		$template_content_replaced 		= substr($this->template_content, 0,$section_start);
		$template_content_replaced 	   .= $section_content_replaced;
		$template_content_replaced 	   .= substr($this->template_content, $section_end+1,$template_content_length-$section_end-1);
		//将$template_content的内容进行替换
		$this->template_content = $template_content_replaced;
	}
	
	
	private function assign_3dim_array($tag_name,$val){
		/** 定义变量处 */
		$section_start 				= 0;//循环块开始的位置
		$section_end 				= 0;//循环块结束的位置
		$section_content 			= null;//存放循环块内容的变量
		$template_content_length 	= 0;//$this->template_content的长度
		$tag_name_length 			= strlen($tag_name);//标签名字的长度，比如$testtag，其长度为7（不包括$符号）
		$section_content_start		= 0;//html标签起始位置
		$section_content_end 		= 0;//html标签结束位置
		$section_content_replaced	= null;//循环块中html被循环替换后的内容
		
		/** 取得模板中section块的内容 并去掉section标签*/
		$section_start=strpos($this->template_content,$this->tag_left_name.'section=$'.$tag_name.$this->tag_right_name);
		$section_end=strpos($this->template_content,$this->tag_left_name.'/section'.$this->tag_right_name);
 	    $section_end = $section_end+10;
 	    //取得循环块
 	    $section_content=substr($this->template_content,$section_start,$section_end-$section_start);
 	    //去掉section标签
 	    $section_content_start 		= 11+$tag_name_length;
		$section_content_end 		= strpos($section_content, $this->tag_left_name.'/section'.$this->tag_right_name);
		$section_content_end 		= $section_content_end-1;
 		$section_content 			= substr($section_content,$section_content_start,$section_content_end - $section_content_start);
 		/** 对块进行section循环处理 */
 		//$val = $this->get_new_array($val);
 		//解析变量。将变量存入数组中，并将循环块中的信息进行替换
 		$i = 0;

 		foreach($val as $key1=>$value1){

 			$section_content_replaced .= $section_content;
 			foreach($value1 as $key2=>$value2){
		 		 if(is_array($value2)){
		 		 	if($this->get_array_dim($value2) == 1){//一维数组的处理
		 		 //		echo "1";
		 		 //		echo $section_content_replaced;
		 		 	//	echo $tag_name."[".$key2."]";
		 				$section_content_replaced = str_replace($tag_name."[".$key2."]", $tag_name."[".$key1."][".$key2."]", $section_content_replaced);
		 		// echo $section_content_replaced;
		 				$section_content_replaced = $this->assign_1dim_array($tag_name."[".$key1."][".$key2."]",$value2,$section_content_replaced);
						//echo $section_content_replaced;
		 		 	}else if($this->get_array_dim($value2) == 2){//二维数组的处理
		 		 		
		 		 	}
		 		 }else{
 				//将变量的名字压入到内存数组中
				array_push($this->tags, $this->tag_left_name."$".$tag_name."[".$key1."][".$key2."]".$this->tag_right_name);
				//将循环块中的一维标签进行替换，并将替换后的模板内容赋值给$foreach_content_replaced
				$section_content_replaced = str_replace($this->tag_left_name."$".$tag_name."[".$key2."]".$this->tag_right_name, $this->tag_left_name."$".$tag_name."[".$key1."][".$key2."]".$this->tag_right_name, $section_content_replaced);
				//将变量对应的内容压入到内存数组中			
				array_push($this->values,$value2);
		 		 }
		 			
 			}
 		}
 		/** 改变$template_content中的内容 */
		$template_content_length 		= strlen($this->template_content);
		$template_content_replaced 		= substr($this->template_content, 0,$section_start);
		$template_content_replaced 	   .= $section_content_replaced;
		$template_content_replaced 	   .= substr($this->template_content, $section_end+1,$template_content_length-$section_end-1);
		//将$template_content的内容进行替换
		$this->template_content = $template_content_replaced;
	}
	
	/**
	 * 
	 * 获取数组的维数
	 * @param unknown_type $arr
	 */
	private function get_array_dim($arr){
		if(is_array($arr)){
  			$dim=0;
  			foreach($arr as $k=>$v){
   				$dim=max($dim,$this->get_array_dim($v));//归调函数本身
  			}
 			return $dim+1;
		}else {
			return 0;	
		}
	}
	
	private function get_new_array($arr){//将二维数组的第一个键值重新定义成0、1、2...
 		 $i=0;
 		 $new_arr=array();
 		 foreach($arr as $k=>$v){
  			$new_arr[$i]=$v;
 			 $i++;
 		 }
  		return $new_arr;
	}
	
	/**
	 * 将外部文件内容替换到模板中
	 * Enter description here ...
	 * @param unknown_type $tag
	 * @param unknown_type $filename
	 */
	public function require_file($tag,$filename){
		$require_start					= NULL;
		$require_end					= NULL;
		$file_content					= NULL;
		$template_content_replaced		= NULL;
		
		$require_start		= strpos($this->template_content,  $this->tag_left_name.'require=$'.$tag.$this->tag_right_name);
		$require_end		= strpos($this->template_content,  $this->tag_left_name.'/require'.$this->tag_right_name);
		
		$file_content = file_get_contents($this->templates_dir.$filename);
		
		$template_content_replaced	= substr($this->template_content,0,$require_start);

		$template_content_replaced .= $file_content;
		$template_content_replaced .= substr($this->template_content, $require_end+10,strlen($this->template_content)-$require_end-1);
		
		$this->template_content		= $template_content_replaced;
	}

	/**
	 * 
	 * 显示替换后模板的内容
	 */
	public function display(){
		//print_r($this->tags);
		echo str_replace($this->tags, $this->values, $this->template_content);
	}
	
	/**
	 * 
	 * 返回替换后的模板的内容
	 * @param $classic 0代表返回替换后的模板；1代表返回为替换的模板
	 */
	private function get_html_contents( $classic = 0){
		if($classic == 0){
			return str_replace($this->tags, $this->values, $this->template_content);
		}else if($classic == 1){
			return $this->template_content;
		}
		
	}
	
	/**
	 * 
	 * 生成静态页面,当未设置content时，就把当前引擎$this->template_content中的内容输入到静态文件中
	 * @param unknown_type $filepath
	 * @param unknown_type $filename
	 */
	public function generate_static_html($filepath = NULL,$filename,$content=NULL){
		if(is_null($filepath)){
			$filepath = ROOT_PATH.SYSTEM_FOLDER.'/static/archives/';
		}
		$filename = $filepath.$filename;
		$handle = fopen($filename,"w");
		if( isset($content)){
			fwrite($handle,$content);
		}else{
			fwrite($handle,$this->get_html_contents(0));
		}
		fclose($handle);
	}
	
	/**
	 * 
	 * 判断文件是否过期，以便进行页面的重新刷新
	 * @param unknown_type $filepath
	 * @param unknown_type $filename
	 */
	public function is_overdue($filepath,$filename){
		if(!isset($filepath) or !isset($filename)){//文件路径及名字进行初始化
			echo "filepath or filename has not been initialed!";
			exit();
		}
		if(file_exists($filepath.$filename) && filemtime($filepath.$filename)+$this->cache_life > time()){//判断文件是否存在和过期
			return false;//文件存在且未过期
			}else{
			return true;//文件过期或者文件不存在
		}	
	}
	
	/**
	 * 
	 * 显示静态页面
	 */
	public function show_static_html($filepath,$filename){
		echo file_get_contents($filepath.$filename);
	}
	
	/**
	 * 删除指定section循环块
	 */
	public function del_section($section_name){
		//获取相应标签位置和长度
		$section_start = strpos($this->template_content, $this->tag_left_name.'section=$'.$section_name.$this->tag_right_name);
		$section_end = strpos($this->template_content, $this->tag_left_name.'/section'.$this->tag_right_name);
		
		$template_content_length = strlen($this->template_content);

		//处理
		$template_content_replaced = substr($this->template_content, 0,$section_start);
		$template_content_replaced .= substr($this->template_content, $section_end+10,$template_content_length-$section_end-10);
		$this->template_content = $template_content_replaced;
		
	}
	
	/**
	 * 删除指定的内容
	 * @param $str 指定要删除的内容
	 * Enter description here ...
	 * @param unknown_type $str
	 */
	public  function  del_specific_content($str){
		$this->template_content = str_replace($str, "", $this->template_content);
	}
	
	/**
	 * 
	 * 判断文件是否存在
	 * @param unknown_type $filepath
	 * @param unknown_type $filename
	 */
	public function is_exits_file($filepath,$filename){
		if(file_exists($filepath.$filename)){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * 
	 * 向当前模板内容追加内容
	 * 
	 * @since Alpha 0.1.0
	 * @access public
	 */
	public function append($content){
		$end = strpos($this->template_content,'</body>');
		$this->template_content =  substr($this->template_content, 0 ,$end) .
									$content . '</body></html>';
	}
}
?>