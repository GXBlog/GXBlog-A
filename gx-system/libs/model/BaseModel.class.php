<?php
/**
 * 数据访问对象(Data Access Object,DAO)基类
 *
 * @version 0.1
 * @since 2013.08.16
 * @author GenialX
 * @link http://www.ihuxu.com
 */

abstract class BaseModel{

	private $connection = NULL;
	
	protected $table						= 'user';
	protected $primary_key					= 'id';
	protected $select_value 				= '*';
	protected $update_value 				= '';
	protected $insert_value					= '';
	protected $require						= 1;
	protected $num							= 100;
	protected $start 						= 0;
	protected $order_field	 				= 'id';
	protected $order 						= 'DESC';
	
	protected function __construct(){
		if(!$this->connect_to_db(DB_USER,DB_PASSWORD,DB_HOST,DB_NAME)){
			exit();
		}
	}

	/**
	 *
	 * 连接数据源
	 * @param String $user
	 * @param String $password
	 * @param String $host
	 * @param String $name
	 * @throws GXException
	 * @return bool
	 */
	private function connect_to_db($user,$password,$host,$name){
		try{
			$this->connection = mysql_connect($host,$user,$password);
			if($this->connection == FALSE){
				throw new GXException(mysql_error($this->connection));
			}
				
			$select_db = mysql_select_db($name,$this->connection);
			if($select_db == FALSE){
				throw new GXException(mysql_error($this->connection));
			}
				
			$set_charset = mysql_query("SET NAMES ".DB_CHARSET);
			if($set_charset == FALSE){
				throw new GXException(mysql_error($this->connection));
			}
		}catch(GXException $e){
			$e->print_stack_trace();
			return FALSE;
		}

		return TRUE;
	}

	/**
	 *
	 * 查询数据
	 * @param String $select_value
	 * @param SqlRequire $SqlRequire
	 * @param int $num
	 * @param int $start
	 * @param String $order_field
	 * @param String $order
	 * @throws GXException
	 * @return SQL执行成功，返回 Array；SQL执行失败，返回 Bool(FALSE)。
	 */
	protected function fetch($select_value = NULL,$SqlRequire = NULL,$num = NULL,$start = NULL,$order_field = NULL,$order = NULL){
		if(is_null($select_value)){
			$select_value = $this->select_value;
		}
		
		$require = NULL;
		
		if(is_null($SqlRequire)){
			$require = $this->require;
		}else{
			$require = $SqlRequire->get_sql_require();
		}
		if(is_null($num)){
			$num = $this->num;
		}
		if(is_null($start)){
			$start = $this->start;
		}
		if(is_null($order_field)){
			$order_field = $this->order_field;
		}
		if(is_null($order)){
			$order = $this->order;
		}

		$sql = "SELECT ".$select_value." FROM ".$this->table." WHERE ".$require." ORDER BY ".
		$order_field." ".$order." LIMIT ".$start." , ".$num;

		try {
			$results = mysql_query($sql,$this->connection);
			
			if(!$results){
				throw new GXException(mysql_error($this->connection).'; SQL:'.$sql.' ');
			}
				
		}catch(GXException $e){
			$e->print_stack_trace();
			return FALSE;
		}

		while($result = mysql_fetch_array($results)){
			$rows[] = $result;
		}

		if(isset($rows)){
			return $rows;
		}
		
		return FALSE;
	}

	/**
	 *
	 * 更新数据
	 * @param array $update_value
	 * @param array $require
	 * @param array $require_logic
	 * @throws GXException
	 * @return bool
	 */
	protected function update($update_value = NULL,$require = NULL,$require_logic = NULL){

		if (is_null($update_value)){
			$update_value = $this->update_value;
		}else{
			$updates = array();
			foreach($update_value as $key => $value){
				$updates[] = " $key = '$value' ";
			}
			$update_value = implode(",", $updates);
		}
		
		if(is_null($require)){
			$require = $this->require;
		}else{
			$_require = null;
			$i = 0;
			if(is_null($require_logic)){
				foreach ($require as $key => $value){
					$_require .= " ".$key." = '".$value."' ".$this->require_default_logic;
				}
			}else{
				foreach ($require as $key => $value){
					$_require .= " ".$key." = '".$value."' ".$require_logic[$i++];
					if($i == (count($require_logic))){
						$i--;
					}
				}
			}
			$require = trim($_require,"AND");
			$require = trim($require,"OR");
			$require = trim($require,"and");
			$require = trim($require,"or");
		}



		$sql = "UPDATE ".$this->table." set ";
		$sql .= $update_value;
		$sql .= " WHERE ".$require;

		try {
			$result = mysql_query($sql,$this->connection);
				
			if(!$result){
				throw new GXException(mysql_error($this->connection).'; SQL:'.$sql.' ');
			}
				
		}catch(GXException $e){
			$e->print_stack_trace();
			return FALSE;
		}

		return TRUE;
	}

	/**
	 *
	 * 增添数据
	 * @param array $value
	 * @throws GXException
	 * @return bool
	 */
	protected function create($value = NULL){

		$keys 			= NULL;
		$values 		= NULL;

		if(is_null($value)){
			$value = $this->insert_value;
		}else{
			foreach ($value as $k => $v) {
				$keys .= " ".$k.",";
				$values .= " '".$v."',";
			}
				
			$keys = trim($keys,",");
			$values = trim($values,",");
		}

		$sql = "INSERT INTO ".$this->table." ( ".$keys." ) VALUE ( ".$values." )";

		try {
			$result = mysql_query($sql,$this->connection);
			if($result == FALSE){
				throw new GXException(mysql_error($this->connection).'; SQL:'.$sql.' ');
			}
		} catch (GXException $e) {
			$e->print_stack_trace();
			return FALSE;
		}

		return TRUE;
	}

	/**
	 *
	 * 删除数据
	 * @param array $require
	 * @param array $require_logic
	 * @throws GXException
	 */
	protected function delete($require = NULL,$require_logic = NULL){

		if(is_null($require)){
			$require = $this->require;
		}else{
			$_require = null;
			$i = 0;
			if(is_null($require_logic)){
				foreach ($require as $key => $value){
					$_require .= " ".$key." = '".$value."' ".$this->require_default_logic;
				}
			}else{
				foreach ($require as $key => $value){
					$_require .= " ".$key." = '".$value."' ".$require_logic[$i++];
					if($i == (count($require_logic))){
						$i--;
					}
				}
			}
			$require = trim($_require,"AND");
			$require = trim($require,"OR");
			$require = trim($require,"and");
			$require = trim($require,"or");
		}

		$sql = "DELETE FROM ".$this->table." WHERE ".$require;

		try {
			$result = mysql_query($sql,$this->connection);
			if($result == FALSE){
				throw new GXException(mysql_error($this->connection));
			}
		} catch (GXException $e) {
			$e->print_stack_trace();
			return FALSE;
		}

		return TRUE;
	}
	
}