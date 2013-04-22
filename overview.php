<?php
include 'inc/header.php';
include 'inc/database.php';
if ( ! isset($_GET['id']) ){
	$target = 'overview.php';
	include 'inc/selector.php';		
}
else {
	/* ===================Show User Ratings==================== */
	$id = $_GET['id']; 
		
	$call = "SELECT * FROM _slot WHERE match_id=".$id;
	$slot_call = mysql_query( $call );
	
	$call = 'SELECT * FROM _user WHERE match_id='.$id;
	$user_call = mysql_query( $call );
	
	// check if Users have signed up yet
	if (mysql_num_rows($user_call)>0) {
		while ($user = mysql_fetch_array( $user_call, MYSQL_ASSOC))	{
			if ( !isset($user_ids)) { 
				$user_ids= array($user["user_id"]);
			} else {
				array_push($user_ids, $user["user_id"]);
			}
		}
		
		$call = "SELECT * FROM _rating WHERE user_id in (".implode(',', $user_ids).")";
		$ranking_call = mysql_query( $call );
		
		
		echo '<table id="anmeldungen" border="1">';
		echo '<thead>';
		 echo "<tr>";
			echo "<th>Name</th>";
			$i=1;
			while ($slot = mysql_fetch_array( $slot_call, MYSQL_ASSOC))	{
				$i=$i+1;
				echo "<th>";
				echo '<p class="slot_name">'. $slot["slot_name"] . '</p>';
				echo "</th>";	
			}
			echo "</tr>";
		echo '</thead>';
		echo '<tbody>';
		
		mysql_data_seek($user_call,0);
		mysql_data_seek($slot_call,0);
		$i=1; 
		while ($user = mysql_fetch_array( $user_call, MYSQL_ASSOC))	{
			echo "<tr>";
			echo '<td>'.$user["user_name"].'</td>';
			while ($slot = mysql_fetch_array( $slot_call, MYSQL_ASSOC))	{
				$i=$i+1;
				$rate = "Not set";
				$call = 'SELECT * FROM _rating WHERE user_id='.$user['user_id'].' AND slot_id='.$slot['slot_id'];
				$rating_call = mysql_query( $call );
				while ($rating = mysql_fetch_array( $rating_call, MYSQL_ASSOC))	{
				if (($rating['slot_id'] = $slot['slot_id']) && ($rating['user_id'] = $user['user_id']))
					$rate = $rating['rating'];
				}
				echo '<td><p class="slot_name">'. $rate . '</p></td>';
			}
			mysql_data_seek($slot_call,0);
			$i=$i+1;
			echo "</tr>";	
		}
		echo '</tbody>';
		echo "</table>";
	}	else { // no user yet
	echo 'No Users have signed in yet';
} //of else
}
?>