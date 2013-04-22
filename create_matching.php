
<html>

<head>


<script>



</script>
</head>
<body>
	<h2>Bisherige Anmeldungen</h2>

<?php 
	include 'inc/database.php';
	$sql = "SELECT * FROM _slot";
	$db_erg = mysql_query( $sql );



if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysql_error());
}

?>

<p>On your E-Mail Account <?php echo $_POST['user_mail']; ?> you have received an E-Mail containing a link to edit your ranting later.</p>
</p>

Du wirst weiter von uns informiert, wenn die Gruppen eingeteilt wurden oder es andere wichtige Änderungen gibt.</p>
<?php
	$call = "SELECT slot_id FROM _slot";
	$slot_call = mysql_query( $call );
	
	$group = isset($_POST['group_id']) ? $_POST['group_id'] : "NULL";

	$sql =  'INSERT INTO _user(match_id, group_id, user_name, user_mail) VALUES '.
		'('.$_POST['match_id'].','.$group.',"'.$_POST['user_name'].'","'.$_POST['user_mail'].'")';
	
	if (!mysql_query($sql))  {
		die('Error: ' . mysql_error());
		}
	echo "Saved the User";

	
	$sql =  'SELECT user_id FROM _user WHERE user_name="'.$_POST['user_name'].'" AND user_mail="'.$_POST['user_mail'].'" AND match_id='.$_POST['match_id'];
	echo '<br />';
	print $sql;
	$user_id = mysql_query($sql);
	echo '<br />';
	print "- count".count($user_id);
	print "- UserID".$user_id;
	echo "- Load the User_ID";
	
	$sql =  'SELECT slot_id FROM _slot WHERE match_id='.$_POST['match_id'];
	echo '<br />';
	print $sql;
	$slot_ids = mysql_query($sql);
	
	$sql = 'INSERT INTO _ranking(user_id, slot_id, ranking) VALUES ';
	while ($slots = mysql_fetch_array( $slot_ids, MYSQL_ASSOC)){
		$rate_id = 'rate'.$slots["slot_id"];
		$sql .= '('.$user_id["user_id"].', '.$slots["slot_id"].', '.$_POST[$rate_id].'),';
	}
	echo '<br />';
	print $sql
	
	/*if (!mysql_query($sql))  {
		die('Error: ' . mysql_error());
		}
	echo "Saved the Ranking;*/

?>

</form>

</body>

</html>