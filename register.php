<?php
include 'inc/header.php';
include 'inc/database.php';
include("classes/Template.class.php");

	function ifExist($value, $default = "") {
		if (isset($_POST[$value]))
			return $_POST[$value];
		else 
			return $default;
	}
	
	if(isset($_POST['save'])) {
		include('classes/manage.class.php');
		
		$manage = new match();
		
		if($manage->process()) {
			header('location: welcome.php');
			exit(1);
		}
		else
			$manage->show_errors();
			
		$id = $manage->getId();
	}
	 
 	
	echo '<div id="myDiv">Das ist der Alte TExt</div>';
	 
	session_start();

	$token = $_SESSION['token'] = md5(uniqid(mt_rand(),true));

	echo 'text'.ifExist('match_desc');
	
	/* Create General Information */
	$gernal_tpl = new Template();
	$gernal_tpl->load("edit_matching.tpl");
	$gernal_tpl->assign( "match_title", ifExist('match_title'));
	$gernal_tpl->assign( "match_desc", ifExist('match_desc'));
	$gernal_tpl->assign( "admin_name", ifExist('admin_name'));
	$gernal_tpl->assign( "admin_mail", ifExist('admin_mail'));
	$gernal_tpl->assign( "match_id", "register");
	$gernal_tpl->assign( "token", $token);
	$gernal_tpl->assign( "mode", ifExist('mode'));
	$gernal_tpl->assign( "grouping", ifExist('grouping'));	
	$general_html = $gernal_tpl->getHtml();
	
	/* Create Slots */
	$slots_html = "";
	$i=1; 
	for ($i = 1; $i <= 3; $i++)	{
		$slot_tpl = new Template();
		$slot_tpl->load("edit_slots.tpl");
		$slot_tpl->assign( "slot_name", ifExist('slot_name'.$i));
		$slot_tpl->assign( "slot_nr", $i);
		$slot_tpl->assign( "slot_desc", ifExist('slot_desc'.$i));
		$slot_tpl->assign( "slot_min", ifExist('slot_min'.$i,0));
		$slot_tpl->assign( "slot_max", ifExist('slot_max'.$i,0));
		$slots_html .= $slot_tpl->getHtml();
	}

	/* Create Page */
	$matching_tpl = new Template();
	$matching_tpl->load("page_edit_matching.tpl");	
	$matching_tpl->assign("edit_general", $general_html);
	$matching_tpl->assign("edit_slots", $slots_html);
	$matching_tpl->assign("action_page", "register.php");
	$matching_tpl-> display();
?>


