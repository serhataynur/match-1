<?php
include 'inc/header.php';
include 'inc/database.php';
include("classes/Template.class.php");

	session_start();
	if(isset($_POST['save'])) {
		include('classes/manage.class.php');
		
		$manage = new match();
		
		if($manage->process())
			echo 'Success';
		else
			$manage->show_errors();
			
		$id = $manage->getId();
	}
	
	$tpl = new Template();
	$tpl->load("welcome.tpl");
	$langs[] = "de/lang_main.php";
	$tpl->loadLanguage($langs);
	$tpl->assign("id", $general['match_title']);
	$general_html = $tpl->getHtml();
	echo $general_html;
?>