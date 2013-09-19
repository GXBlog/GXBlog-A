<?php
class LogicSqlRequire extends SqlRequire{
	
	private $require = NULL;
	
	public function __construct($require){
		$this->require = $require;
	}
	
	public function get_sql_require(){

		$_require 		= NULL;
		$i	 			= 0;
		
		foreach ($this->require[0] as $key => $value){
			$_require .= " ".$key." = '".$value."' ".$this->require[1][$i++];
			if($i == (count($this->require[1]))){
				$i--;
			}
		}
		
		$this->require 		= trim($_require,"AND");
		$this->require 		= trim($this->require,"OR");
		$this->require 		= trim($this->require,"and");
		$this->require 		= trim($this->require,"or");
			
		return $this->require;
	}
	
}