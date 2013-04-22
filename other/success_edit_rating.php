<?php 
	include 'inc/header.php';
	include 'database.php';
	$sql = "SELECT * FROM _slot";
	$db_erg = mysql_query( $sql );

if ( ! $db_erg )  die('Ungültige Abfrage: ' . mysql_error());
?>
	<h2>Changed Settings</h2>
<p>{$confirmation_text1}</p>
</p>
<?php

	/* Save User Information*/
	$sql =  'SELECT * FROM _user WHERE user_id='.$_POST['user_id'];
	$user_query = mysql_query( $sql );
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
	
	/* Save Ratings */
	$db_erg = mysql_query( "SELECT * FROM _slot" );
	if ( ! $db_erg )	die('Ungültige Abfrage: ' . mysql_error());
	
	$call = "SELECT * FROM _rating WHERE user_id=".$_POST['user_id'];
	$rate_call = mysql_query( $call );
	
	$i=1;
	$sql = '';
	$messages = '';
	//$tpl->assign( "name", $user['user_name'] );
	while ($slot = mysql_fetch_array( $db_erg, MYSQL_ASSOC))	{
		$sql .= 'WHEN user_id = '.$_POST['user_id'].' AND slot_id = '.$slot['slot_id'].' THEN ' . $_POST['rate'.$i]. ' ';	
		$i++;
	}
	
	if ($sql!="") {
		$sql = 'UPDATE _rating SET rating = CASE '. $sql . 'END';
		if (!mysql_query($sql))  {
			die('Error: ' . mysql_error() . ' : ' . $sql);
		} else {
			echo 'changes worked '. $sql;
		}
	}
	
	//TODO: Send E-Mail
?>

</body>

</html>