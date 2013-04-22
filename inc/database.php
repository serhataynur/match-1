<?php
// Damit alle Fehler angezeigt werden
error_reporting(E_ALL);

 
// Zum Aufbau der Verbindung zur Datenbank
// die Daten erhalten Sie von Ihrem Provider
/*define ( 'MYSQL_HOST',      'rdbms.strato.de' );
define ( 'MYSQL_BENUTZER',  'U1023043' );
define ( 'MYSQL_KENNWORT',  'frankfurterstrasse100' );
define ( 'MYSQL_DATENBANK', 'DB1023043' );*/

// die Daten erhalten Sie von Ihrem Provider
define ( 'MYSQL_HOST',      'localhost' );
define ( 'MYSQL_BENUTZER',  'root' );
define ( 'MYSQL_KENNWORT',  '' );
define ( 'MYSQL_DATENBANK', 'matching' );
 
//$db_link = mysql_connect('rdbms.strato.de:3306',MYSQL_BENUTZER,MYSQL_KENNWORT) or die(mysql_error()); 

//mysql_select_db(MYSQL_DATENBANK, $db_link) or die(mysql_error()); 
$db_link = mysql_connect (MYSQL_HOST, 
                          MYSQL_BENUTZER, 
                          MYSQL_KENNWORT);
 $db_sel = mysql_select_db( MYSQL_DATENBANK )
   or die("Auswahl der Datenbank fehlgeschlagen");
 ?>