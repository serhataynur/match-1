<?php
class match
{
    private $user_name = "";
    private $user_mail = "";
		
		private $match_id = "";
		private $user_id = "";
		private $token = "";
		private $ident = "";
		
		private $mode = 1;
		private $grouping = false;

    public function __construct() {
        $this -> errors = array();
				
				$this->user_name = $this->filter($_POST['user_name']);
				$this->user_mail = $this->filter($_POST['user_mail']);
				
				$this->match_id = $_POST['match_id'];
				$this->user_id = $_POST['user_id'];
				$this->ident = md5($this->user_name.'|'.$this->user_mail);
				$this->token = $_POST['token'];
			
				//echo 'User'.$this->username.",".$_POST['ruser'];
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

		public function save() {
			/* Save User */
		  $group = isset($_POST['group_id']) ? $_POST['group_id'] : "NULL";

			// New User Insert
			if(empty($this->user_id)) {
				//TODO: Check 
				
				$sql =  'INSERT INTO _user(match_id, group_id, user_name, user_mail) VALUES '.
					'('.$this->match_id.','.$group.',"'.$_POST['user_name'].'","'.$_POST['user_mail'].'")';
				if (!mysql_query($sql))  {
					die('Error: ' . mysql_error());
					}
				
				if(mysql_affected_rows() < 1)
					$this->errors[] = ' | Could Not Save Ratings';
			} 
			
			// User ID Existing
			else {
				$sql =  'SELECT * FROM _user WHERE user_id='.$this->user_id;
				$user_query = mysql_query( $sql );
				print $sql;
				$user = mysql_fetch_array( $user_query, MYSQL_ASSOC);
				
				$messages = "";
				$sql =  '';
			
				if ($user['user_name'] != $_POST['user_name']) {
					$sql .=  ' user_name="'.$_POST['user_name'].'",' ;
					$messages .= '<p class="changed">Username changed: '.$_POST['user_name'].'</p>';
				}
				
				if ($user['user_mail'] != $_POST['user_mail']) {
					$sql .=  ' user_mail="'.$_POST['user_mail'].'",' ;
					$messages .= 'change user_mail';
				}
				
				if ($messages != "") {
					$sql = substr_replace($sql ,"",-1);
					$sql = 'UPDATE _user SET'. $sql . ' WHERE user_id='.$_POST['user_id'];
					if (!mysql_query($sql))  {
						die('Error: ' . mysql_error() . ' : ' . $sql);
					}
					echo $messages;
				} else {
					echo '<div>No Name changes</div>';
				}
			}

		 // Change Rating
		 if(mysql_affected_rows() < 1)
				$this->errors[] = 'Could Not Save User Changes';
				
			/* Save rating */
			$sql =  'SELECT slot_id FROM _slot WHERE match_id='.$_POST['match_id'];
			$slot_ids = mysql_query($sql);
			
			
			$user_id = $this->getId();
			$sql = 'REPLACE _rating(user_id, slot_id, rating) VALUES ';
			while ($slots = mysql_fetch_array( $slot_ids, MYSQL_ASSOC)){
				$rate_id = 'rate'.$slots["slot_id"];
				$sql .= '('.$user_id.', '.$slots["slot_id"].', '.$_POST[$rate_id].'),';
			}
			$sql = substr_replace($sql ,"",-1);
			print $sql;
			if (!mysql_query($sql))  {
				die('Error: ' . mysql_error());
			}
			//REPLACE INTO my_table (pk_id, col1) VALUES (5, '123');
			if(mysql_affected_rows() < 1)
				$this->errors[] = 'Could Not Save Ratings';
		}
		
		public function show_errors() {
			foreach($this->errors as $key=>$value)
				echo $value."<br/>";
		}
		
		public function valid_data() {
			if(empty($this->user_name))
				$this->errors[] = 'Please insert an Username: ';
			if(empty($this->user_mail))
				$this->errors[] = 'Please insert an Email';
			//TODO: Check E-Mail
				
			return count($this->errors)?0:1;
		}
		
		public function getId() {
			$sql =  'SELECT user_id FROM _user WHERE match_id="'.$this->match_id.'" AND user_name="'.$this->user_name.'" and user_mail="'.$this->user_mail.'"';
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