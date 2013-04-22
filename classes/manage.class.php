<?php
class match
{
		private $match_title = "";
		private $match_desc = "";
    private $admin_name = "";
    private $admin_mail = "";
		private $match_pass = "";
		private $default_min = 0;
		private $default_max = 0;
		private $mode = 1;
		private $grouping = false;
		
		private $match_id = "";
		private $token = "";
		private $ident = "";
		
    public function __construct() {
        $this -> errors = array();
				
				$this->match_title = $this->filter($_POST['match_title']);
				$this->match_desc = $this->filter($_POST['match_desc']);
				$this->admin_name = $this->filter($_POST['admin_name']);
				$this->admin_mail = $this->filter($_POST['admin_mail']);
				$this->match_pass = $this->filter($_POST['match_pass']);
				
				if (isset($_GET['id']))
					$this->match_id = $_GET['id'];
				else
					$this->match_id = "";
				echo $this->match_id;
				$this->token = $_POST['token'];
    }
		
		public function process() {
			if($this->valid_token() && $this->valid_data())
					$this->save();
					
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

		public function save_slot() {
			$sql = 'REPLACE _rating(user_id, slot_id, rating) VALUES ';
		}
		
		public function save() {
			// New Matching Insert
			if(empty($this->match_id)) {
				//TODO: Check 
				$sql =  'INSERT INTO _general(match_title, match_desc, match_pass, admin_name, admin_mail, default_min, default_max, mode, grouping) VALUES ("'.
												$this->match_title.'","'.$this->match_desc.'","'.$this->match_pass.'","'.$this->admin_name.'","'.$this->admin_mail.'","'.$this->default_min.'","'.$this->default_max.'","'.$this->mode.'","'.$this->grouping.'")';
				
				if (!mysql_query($sql))  {
					die('Error: ' . mysql_error());
					}
				
				if(mysql_affected_rows() < 1)
					$this->errors[] = ' | Could Not Save Basic Settings';
			} 
			
			// User ID Existing
			else {
				$sql =  'UPDATE _general SET match_title="'.$this->match_title.'",'.
				'match_desc="'.	$this->match_desc.'",'.
				'match_pass="'.	$this->match_pass.'",'.
				'admin_name="'.	$this->admin_name.'",'.
				'admin_mail="'.	$this->admin_mail.'",'.
				'default_min="'.$this->default_min.'",'.
				'default_max="'.$this->default_max.'",'.
				'mode="'.				$this->mode.'",'.
				'grouping="'.		$this->grouping.'" '.
				'WHERE match_id='. $this->match_id;
				
				if (!mysql_query($sql))  {
					die($this->errors[] = ' | Could Not Save Basic Settings');
				}					
				
				$i=0;
				foreach($_REQUEST as $key=>$value){
						echo $i.") ".$key.$value."<br/>";
						$i++;
				}
			}
			
			// Save Slots
			
		}
		
		public function show_errors() {
			foreach($this->errors as $key=>$value)
				echo $value."<br/>";
		}
		
		public function valid_data() {
			if(empty($this->match_title))
				$this->errors[] = 'Please insert a title for the matching: ';
			if(empty($this->admin_name))
				$this->errors[] = 'Please insert your name';
			if(empty($this->admin_mail))
				$this->errors[] = 'Please insert an your email';
				
		/*	if (empty($this->match_id))
				$sql =  "SELECT * FROM _rating WHERE slot_id=".$_POST['remove'];
				$slot_ids = mysql_query($sql);
				$slots = mysql_fetch_array( $slot_ids, MYSQL_ASSOC);
				if (empty($slots))
				$this->errors[] = 'You can not create to Matchings with the same name. Please insert a name you have not created till now.';
			*///TODO: Check E-Mail
				
			return count($this->errors)?0:1;
		}
		
		public function getId() {
			$sql =  'SELECT match_id FROM _general WHERE admin_name="'.$this->admin_name.'" AND admin_mail="'.$this->admin_mail.'" AND match_title="'.$this->match_title.'"';
			echo $sql;
			$query = mysql_query($sql);
			$user_id = mysql_fetch_array( $query, MYSQL_ASSOC);	
			return $user_id['user_id'];
		}
		
		public function valid_token() {
			if(!isset($_SESSION['token']))
				$this->errors[] = 'invalid token';
			// Save token in Database and get it from there: http://www.youtube.com/watch?v=7-g9E7BMCkE
			/*if($this->token != $_SESSION['token'])
				$this->errors[] = 'this->token '.$this->token.' | Session token '.$_SESSION['token'] ;
			*/
			return count($this->errors)?0:1;
		}
}
?>