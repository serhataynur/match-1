<br /><br />
		<h2>{L_RATE_TITLE}</h2>

		<form id="rate_project" action="{$action_page}" method="post">
		<input type="hidden" name="match_id" value="{$match_id}">
		<input type="hidden" name="user_id" value="{$user_id}">
		<input type="hidden" name="token" value="{$token}">
		<label for="user_name">{L_YOUR_NAME}:</label><input name="user_name" type="text" value="{$name}">
		<label for="user_mail">{L_YOUR_MAIL}:</label><input name="user_mail" type="email" required="required" value="{$mail}">  
		 
		 {$slots_rantings}
		 
		<input type="submit" name="save" value="Speichern">
		</form>