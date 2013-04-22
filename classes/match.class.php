<?php
class match
{
		private $match_title = "";
		private $match_desc = "";
    private $admin_name = "";
    private $admin_mail = "";
		private $admin_pass = "";
		private $mode = 1;
		private $grouping = false;

    public function __construct($tpl_dir = "", $lang_dir = "") {
        $this -> errors = array();
				
				$this->username = $this->filter($_POST('ruser'));
				$this->password = $this->filter($_POST('ruser'));
				$this->emailws = $this->filter($_POST('ruser'));
				
				$this->passmd5 = md5($this->password);
    }
		
		public function process() {
			if($this->valid_token() && $this->valid_data())
					$this->register();
					
			return count($this->errors)?0:1;
		}
		
		public function filter($var) {
			return preg_replace('/[â-zA-Z0-9@.]/','',$var);
		}
		
		public function user_exists() {
		
		
			if(mysql_affected_rows() < 1)
				$this->errors[] = 'Could Not Process Form';
		}

		public function register() {
		 mysql_query();
		 
		 if(mysql_affected_rows() < 1)
				$this->errors[] = 'Could Not Process Form';
		}
		
		public function show_errors() {
			foreach($this->errors as $key=>$value)
				echo $value."<br/>";
		}
		
		public function valid_data() {
			if(empty($this->username))
				this->errors[] = 'Invalid Username';
			if(empty($this->password))
				this->errors[] = 'Invalid Password';
			if(empty($this->email))
				this->errors[] = 'Invalid Email';
				
			return count($this->errors)?0:1;
		}
		
		public function valid_token() {
			if(!isset($_SESSION['token']) || $this->token != $_SESSION['token'])
				$this->errors[] = 'invalid token';
			
			return count($this->errors)?0:1;
		}
}
?>