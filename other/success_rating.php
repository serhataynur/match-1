<?php 
	include 'inc/header.php';
	include 'database.php';
	$sql = "SELECT * FROM _slot";
	$db_erg = mysql_query( $sql );

if ( ! $db_erg )  die('Ungültige Abfrage: ' . mysql_error());
?>
	<h2>Bisherige Anmeldungen</h2>
<p>{$confirmation_text1}</p>
</p>
<?php
	/* Save User */
	$group = isset($_POST['group_id']) ? $_POST['group_id'] : "NULL";

	$sql =  'INSERT INTO _user(match_id, group_id, user_name, user_mail) VALUES '.
		'('.$_POST['match_id'].','.$group.',"'.$_POST['user_name'].'","'.$_POST['user_mail'].'")';
	
	if (!mysql_query($sql))  {
		die('Error: ' . mysql_error());
		}
	
	/* Get User ID*/
	$sql =  'SELECT user_id FROM _user WHERE user_name="'.$_POST['user_name'].'" AND user_mail="'.$_POST['user_mail'].'" AND match_id='.$_POST['match_id'].' LIMIT 1';
	$user = mysql_query( $sql );
	if (mysql_num_rows($user)==1) {
		$user_id = mysql_fetch_array( $user);
		$user_id = $user_id["user_id"];
		echo "Load the User_ID ".$user_id;
	} else {
		die('Zu viele Rückgabewerte - nicht klar identifizierter User, Anzahl gefundener Werte: ' . mysql_num_rows($user));
	}
	
	/* Save rating */
	$sql =  'SELECT slot_id FROM _slot WHERE match_id='.$_POST['match_id'];
	$slot_ids = mysql_query($sql);
	
	$sql = 'INSERT INTO _rating(user_id, slot_id, rating) VALUES ';
	while ($slots = mysql_fetch_array( $slot_ids, MYSQL_ASSOC)){
		$rate_id = 'rate'.$slots["slot_id"];
		$sql .= '('.$user_id["user_id"].', '.$slots["slot_id"].', '.$_POST[$rate_id].'),';
	}
	$sql = substr_replace($sql ,"",-1);
	
	if (!mysql_query($sql))  {
		die('Error: ' . mysql_error());
	}

?>

</form>

</body>

</html>