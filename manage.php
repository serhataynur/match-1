<?php
include 'inc/header.php';
include 'inc/database.php';
include("classes/Template.class.php");

if ( ! isset($_GET['id']) ){
	$target = 'manage.php';
	include 'inc/selector.php';		
}
else {
	session_start();
	if(isset($_POST['save'])) {
		include('classes/manage.class.php');
		
		$manage = new match();
		
		if($manage->process())
			echo 'Success';
		else
			$manage->show_errors();
	}

	if(isset($_POST['remove'])) {
		$sql =  "SELECT * FROM _slot WHERE slot_id=".$_POST['remove'];
		$slot_ids = mysql_query($sql);
		$slots = mysql_fetch_array( $slot_ids, MYSQL_ASSOC);
		// Not Saved field - can be deleted directly
		if (empty($slots))
			echo 'empty';
		else 
			$sql =  "SELECT * FROM _rating WHERE slot_id=".$_POST['remove'];
			$slot_ids = mysql_query($sql);
			$slots = mysql_fetch_array( $slot_ids, MYSQL_ASSOC);
			if (empty($slots))
				echo 'empty';
			else {
			echo count($slots);
			echo 'Are you sure you want to delete this files since some user allready rated this slot?';
			
			}
			
			
		
		
	}

	$token = $_SESSION['token'] = md5(uniqid(mt_rand(),true));

	$id = $_GET['id']; 
	/* Get General Information */
	$call = "SELECT * FROM _general WHERE match_id=".$id;
	$general_call = mysql_query( $call );
	$general = mysql_fetch_array( $general_call, MYSQL_ASSOC);
	
	/* Create General Information */
	$gernal_tpl = new Template();
	$gernal_tpl->load("edit_matching.tpl");
	$gernal_tpl->assign( "match_title", $general['match_title'] );
	$gernal_tpl->assign( "match_desc", $general['match_desc'] );
	$gernal_tpl->assign( "admin_name", $general['admin_name'] );
	$gernal_tpl->assign( "admin_mail", $general['admin_mail'] );
	$gernal_tpl->assign( "match_id", $_GET['id']);
	$gernal_tpl->assign( "token", $token);
	$gernal_tpl->assign( "mode".$general['mode'], "selected");
	$gernal_tpl->assign( "grouping".$general['grouping'], "selected");	
	$general_html = $gernal_tpl->getHtml();

	/* Get Slot Information */
	$call = "SELECT * FROM _slot WHERE match_id=".$id;
	$slot_call = mysql_query( $call );
	
	/* Create Slots */
	$slots_html = "";
	$i=1; 
	while ($slot = mysql_fetch_array( $slot_call, MYSQL_ASSOC))	{
		$slot_tpl = new Template();
		$slot_tpl->load("edit_slots.tpl");
		$slot_tpl->assign( "slot_name", $slot["slot_name"] );
		$slot_tpl->assign( "slot_nr", $i);
		$slot_tpl->assign( "slot_desc", $slot['slot_description']);
		$slot_tpl->assign( "slot_min", $slot['slot_min']);
		$slot_tpl->assign( "slot_max", $slot['slot_max']);
		$slots_html .= $slot_tpl->getHtml();
		$i++;
	}

	/* Create Page */
	$matching_tpl = new Template();
	$matching_tpl->load("page_edit_matching.tpl");	
	$matching_tpl->assign("edit_general", $general_html);
	$matching_tpl->assign("edit_slots", $slots_html);
	$matching_tpl->assign("action_page", $_SERVER['PHP_SELF']."?id=".$_GET['id']);
	$matching_tpl-> display();
	
}
?>


