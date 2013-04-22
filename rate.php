<?php
include 'inc/header.php';
include("classes/Template.class.php");
include 'inc/database.php';
//mysql_close();
session_start();
if(isset($_POST['save'])) {
	include('classes/rate.class.php');
	
	$register = new match();
	
	if($register->process())
		echo 'Success';
	else
		$register->show_errors();
}

$token = $_SESSION['token'] = md5(uniqid(mt_rand(),true));

// No Matching specified > Select Page
if (!isset($_GET['edit']) && !isset($_GET['id'])) {
	$target = "rate.php";
	include 'inc/selector.php';		
} else {
	/* Project is defined, create Rating Template*/
	
	// Load Template
	$tpl = new Template();
	$tpl->load("rate.tpl");

	// Load language files
	$langs[] = "de/lang_main.php";
	$lang = $tpl->loadLanguage($langs);
	
	$tpl->assign( "token", $token);

	/* Create a new User Rating to an defined matching */
	if ( isset($_GET['id']) ){
		$tpl->assign( "action_page", $_SERVER['PHP_SELF']."?edit=".$_GET['id']);
		
		// Set User Defaults
		$tpl->assign( "name", "Nico" );
		$tpl->assign( "mail", "nico.kreiling@gmx.de" );
		
		// Define match id from User Data
		$tpl->assign( "match_id", $_GET['id'] );
		$tpl->assign( "user_id", "");
	}
	
	/* Edit an existing ranking */
	elseif ( isset($_GET['edit']) ){
		$user_id = $_GET['edit'];
		$tpl->assign( "action_page", "?edit=".$_GET['edit']);
		
		// Load User Settings
		$call = mysql_query("SELECT * FROM _user WHERE user_id=".$user_id);
		$user = mysql_fetch_array( $call);
		$tpl->assign( "name", $user['user_name'] );
		$tpl->assign( "mail", $user['user_mail'] );
		$tpl->assign( "user_id", $user_id);
		
		// Define match id from User Data
		$tpl->assign( "match_id", $user['match_id']);
		
		// Load Ratings of user
		$call = "SELECT * FROM _rating WHERE user_id=".$user_id;
		$rate_call = mysql_query( $call );
	} 
	
	/* Create Slots */
	$db_erg = mysql_query( "SELECT * FROM _slot" );
	if ( ! $db_erg )	die('Ungültige Abfrage: ' . mysql_error());
	
	$slots_rating = "";
	$i=1; 
	while ($slot = mysql_fetch_array( $db_erg, MYSQL_ASSOC))	{
		$slot_tpl = new Template();
		$slot_tpl->load("rate_slots.tpl");
		$slot_tpl->assign( "slot_name", $slot["slot_name"] );
		$slot_tpl->assign( "slot_nr", $i);
		$slot_tpl->assign( "slot_description", $slot['slot_description']);
		
		// Define existing values if editing page
		if (isset($rate_call)) {
			while ($rate = mysql_fetch_array( $rate_call, MYSQL_ASSOC)){
				if ($rate["slot_id"]==$slot['slot_id'])
					$slot_tpl->assign( "slot_value", $rate["rating"]);
			}
			if (mysql_fetch_lengths($rate_call)>0)
				mysql_data_seek($rate_call,0);
		}
		
		$slots_rating .= $slot_tpl->getHtml();
		$i++;
	}
		
	// Zugriff auf eine Sprachvariable
	$tpl->assign( "slots_rantings", $slots_rating );

	// Und die Seite anzeigen
	$tpl->display();
	
	mysql_free_result( $db_erg );
}

?>