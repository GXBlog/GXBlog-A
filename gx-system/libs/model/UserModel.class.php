<?php
/**
 * User数据访问对象
 *
 * @version  0.1
 * @since 2013.08.16
 * @author GenialX
 * @link http://www.ihuxu.com
 */

class UserModel extends BaseModel{

	private static $instance 				= NULL;

	protected $table						= 'user';

	protected function __construct(){
		parent::__construct();
	}

	public static function get_instance(){
		if(!self::$instance instanceof self){
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function log($username,$password){

		$require = array('username'=>$username);
		$rows = $this->fetch('password',$require);

		if(is_array($rows)){
			if(count($rows) != 0){
				$shell = null;
				foreach ($rows as $value) {
					$shell = $value['password'];
				}
				if($shell == $password){
					$_SESSION['username'] = $username;
					$_SESSION['password'] = $password;
					return TRUE;
				}
			}
		}
		return FALSE;
	}

	public function logout(){
		
		if(isset($_SESSION['username']) && isset($_SESSION['password']) ){
			unset($_SESSION['username']);
			unset($_SESSION['password']);
			return TRUE;
		}
		return FALSE;
	}
	
	public function is_log(){
		if(isset($_SESSION['username']) && isset($_SESSION['password']) ){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function modify_password($username,$new_password){
		$update_value = array('password'=>$new_password);
		$require = array('username'=>$username);

		$this->update($update_value,$require);
	}

	public function create_user($username,$password,$email){
		$value = array('username'=>$username,'password'=>$password,'email'=>$email);
		$this->create($value);
	}

	public function delete_user($username,$password){
		$require = array('username'=>$username,'password'=>$password,'email'=>'huxu@154.com');
		$require_logic = array(0=>'and',1=>'and');

		$this->delete($require);
	}

}