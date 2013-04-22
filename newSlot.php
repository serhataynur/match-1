<?php 
include("classes/Template.class.php");
$i = $_GET['nr'];

$slot_tpl = new Template();
$slot_tpl->load("edit_slots.tpl");
$slot_tpl->assign( "slot_name", "");
$slot_tpl->assign( "slot_nr", $i);
$slot_tpl->assign( "slot_desc", "");
$slot_tpl->assign( "slot_min", 0);
$slot_tpl->assign( "slot_max", 0);
echo $slot_tpl->getHtml();

?>