<?php			

include 'inc/database.php';
$sql =  "truncate table _rating";;
/*$querry = mysql_query($sql);
$slots = mysql_fetch_array( $querry, MYSQL_ASSOC);
			if (empty($slots))
				echo 'empty';*/
if (!mysql_query($sql))  {
	die('Error: ' . mysql_error());
}
if(mysql_affected_rows() < 1)
				echo 'No Changes in Rating <br/>';
				
$sql =  "DELETE FROM `_slot`";
/*$querry = mysql_query($sql);
$slots = mysql_fetch_array( $querry, MYSQL_ASSOC);
			if (empty($slots))
				echo 'empty';*/
if (!mysql_query($sql))  {
	die('Error: ' . mysql_error());
}
if(mysql_affected_rows() < 1)
				echo 'No Changes in Slots <br/>';
				
$sql =  "DELETE FROM `_user`";
/*$querry = mysql_query($sql);
$slots = mysql_fetch_array( $querry, MYSQL_ASSOC);
			if (empty($slots))
				echo 'empty';*/
if (!mysql_query($sql))  {
	die('Error: ' . mysql_error());
}
if(mysql_affected_rows() < 1)
				echo 'No Changes in User <br/>';
				
$sql =  "DELETE FROM `_general`";
/*$querry = mysql_query($sql);
$slots = mysql_fetch_array( $querry, MYSQL_ASSOC);
			if (empty($slots))
				echo 'empty';*/
if (!mysql_query($sql))  {
	die('Error: ' . mysql_error());
}
if(mysql_affected_rows() < 1)
				echo 'No Changes in General <br/>';
				
?>