<?php
class SingleSqlRequire extends SqlRequire{
	
	private $require = NULL;
	
	public function __construct($require){
		$this->require = $require;
	}
	
	public function get_sql_require(){
		
		$_require = NULL;
		
		foreach ($this->require[0] as $key => $value){
			$_require .= " ".$key." = '".$value."' AND";
		}
		
		$require = trim($_require,"AND");
		
		return $require;
	}
}