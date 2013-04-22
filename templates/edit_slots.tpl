<div class="edit_slot slot{$slot_nr}">
	<input type="submit" name="remove" class="remove" alt="Löschen" value="{$slot_nr}">
	<div>
		<label for="name{$slot_nr}">Titel</label>
		<input type="input" name="name{$slot_nr}" id="name{$slot_nr}" value="{$slot_name}" /><br/>
		<label for="min{$slot_nr}">Min</label>
		<input type="input" name="min{$slot_nr}" id="min{$slot_nr}" value="{$slot_min}" /><br/>
		<label for="max{$slot_nr}">Max</label>
		<input type="input" name="max{$slot_nr}" id="max{$slot_nr}" value="{$slot_max}" /><br/>
	</div>
	<textarea name="desc{$slot_nr}" id="desc{$slot_nr}">{$slot_desc}</textarea>
</div>
