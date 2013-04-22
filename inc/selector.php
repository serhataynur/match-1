<?php 	
	$call = "SELECT * FROM _general";
	$db_erg = mysql_query( $call );
	
  echo '<form id="select_project" action="'.$target.'" method="get">';
	echo '<select name="id" >';
	while ($projects = mysql_fetch_array( $db_erg, MYSQL_ASSOC)){
		echo '<option value='. $projects["match_id"] . ' name="match_id">'. $projects["match_title"] . '</option>';
	}
	echo '<input type="submit" value="Senden">';
	echo "</select></form>";
?>
