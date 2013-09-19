<?php
class RelationSqlRequire extends SqlRequire{
	
	private $require = NULL;
	
	public function __construct($require){
		$this->require = $require;
	}

	public function get_sql_require(){
		
		$_require 		= NULL;
		$i				= 0;
		$j				= 0;
		
		foreach ($this->require[0] as $key => $value){
			
			$_require .= " ".$key." ".$this->require[2][$j++]." '".$value."' ".$this->require[1][$i++];
			
			if($i == (count($this->require[1]))){
				$i--;
			}
			
		}
			
		$this->require 		= rtrim($_require,"AND");
		$this->require 		= rtrim($this->require,"OR");
		$this->require 		= rtrim($this->require,"and");
		$this->require 		= rtrim($this->require,"or");
		
		return $this->require;
	}
	
}