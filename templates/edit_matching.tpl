	<div>
		<label for="match_title">Titel</label>
		<input type="text" id="match_title" name="match_title" value="{$match_title}" required="required">  
		<label for="match_desc">Beschreibung</label>
		<textarea type="text" id="match_desc" name="match_desc">{$match_desc}</textarea>
	</div>
	
	<div>
		<label for="admin_name">Ihr Name</label>
		<input type="text" id="admin_name" name="admin_name" value="{$admin_name}"> 
		<label for="admin_name">Ihre E-Mail</label>		
		<input type="email" id="admin_mail" name="admin_mail" value="{$admin_mail}" required="required">  
	</div>
	
	<div>
		<label for="match_pass">Neues Passwort</label>
		<input type="password" id="match_pass" name="match_pass" value="">  
		<label for="match_pass_repeat">Neues Passwort wiederholen</label>
		<input type="password" id="match_pass_repeat" name="match_pass_repeat" value="">  
	</div>
	
	<input type="hidden" id="match_id" name="match_id" value="">  
	<input type="hidden" id="token" name="token" value="{$token}">  	
	
		<div>
		<select>
			<option value="1" {$mode1}>optimal matching</option>
			<option value="2" {$mode2}>match people</option>
			<option value="3" {$mode3}>match slots</option>
		</select>

		<select>
			<option value="0" {$grouping1}>Grouping dissabled</option>
			<option value="1" {$grouping2}>Grouping enabled</option>
		</select>
	</div>
	