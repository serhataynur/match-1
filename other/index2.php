<?php
include("Template.class.php");

// Das Template laden
$tpl = new Template();
$tpl->load("index.tpl");

// Die Sprachdatei laden
$langs[] = "de/lang_main.php";
$lang = $tpl->loadLanguage($langs);

// Platzhalter ersetzen
$tpl->assign( "your_mail", "mail" );
$tpl->assign( "time",          date("H:i") );

// Zugriff auf eine Sprachvariable
$tpl->assign( "test",          $lang['test'] );

// Und die Seite anzeigen
$tpl->display();
?>