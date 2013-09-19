<?php
/**
 * 异常处理扩展类
 * 
 * @version 0.1
 * @since 2013.08.16
 * @author GenialX
 * @link http://www.ihuxu.com
 */

class GXException extends Exception{
	
	private $debug			= DEBUG;
	
	public function __construct($message,$code = 0){
		parent::__construct($message, $code);
	}
	
	public function print_stack_trace(){
		if($this->debug){
			echo "Error: ".$this->getMessage()." ";
			echo "in ".$this->getFile()." on line ". $this->getLine();
			echo "</br>";
			echo $this->getTraceAsString();
			echo "</br>";
		}
	}
	
}