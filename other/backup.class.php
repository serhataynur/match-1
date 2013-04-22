<?php
class match
{
		private $match_title = "";
		private $match_desc = "";
    private $admin_name = "";
    private $admin_mail = "";
		private $admin_pass = "";
		private $username = "";
		private $password = "";
		private $emailws = "";
		private $passmd5 = "";
		private $token = "";
		
		private $mode = 1;
		private $grouping = false;

    public function __construct() {
        $this -> errors = array();
				
				$this->username = $this->filter($_POST['ruser']);
				$this->password = $this->filter($_POST['rpass']);
				$this->emailws = $this->filter($_POST['remail']);
				$this->token = $_POST['token'];
				
				$this->passmd5 = md5($this->password);
				//echo 'User'.$this->username.",".$_POST['ruser'];
    }
		
		public function process() {
			if($this->valid_token() && $this->valid_data())
					$this->register();
					
			return count($this->errors)?0:1;
		}
		
		public function filter($var) {
			//return preg_replace('/[a-zA-Z0-9@.]/','',$var);
			return $var;
		}
		
		/*public function user_exists() {
			if(mysql_affected_rows() < 1)
				$this->errors[] = 'Could Not Process Form';
		}*/

		public function register() {
		 //mysql_query();
		 
		 if(mysql_affected_rows() < 1)
				$this->errors[] = 'Could Not Process Form';
		}
		
		public function show_errors() {
			foreach($this->errors as $key=>$value)
				echo $value."<br/>";
		}
		
		public function valid_data() {
			if(empty($this->username))
				$this->errors[] = 'Invalid User: '.$this->username;
			if(empty($this->password))
				$this->errors[] = 'Invalid Password';
			if(empty($this->emailws))
				$this->errors[] = 'Invalid Email';
				
			return count($this->errors)?0:1;
		}
		
		public function valid_token() {
			if(!isset($_SESSION['token']))
				$this->errors[] = 'invalid token';
			// Save token in Database and get it from there: http://www.youtube.com/watch?v=7-g9E7BMCkE
			if($this->token != $_SESSION['token'])
				$this->errors[] = 'invalid token 2';
			
			return count($this->errors)?0:1;
		}
}
?>