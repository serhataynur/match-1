<script>
$(document).ready(function(){
    $('#add_slot').click(function() {
			var amount = $(".edit_slot").size()+1;
		
			$(this).before('<div id="newElement"></div>');
			console.log("test");
			var xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function()
				{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
					{
					console.log("test");
					//$(document.createElement()).insertAfter('#newElement');
					$(xmlhttp.responseText).insertBefore('#add_slot');
					}
			}
			xmlhttp.open("GET","newSlot.php?nr="+amount,true);
			xmlhttp.send();
			})
			
		$('.remove').click(function(event) {
			event.preventDefault();
			var nr = $(this).attr('value');
			$('.slot'+nr).remove();
		})
});


</script>

<h2>{L_MANAGE_TITLE}</h2>

<form id="rate_project" action="{$action_page}" method="post">
	{$edit_general}
	{$edit_slots}
	<div id="newSlots">
		<a id="add_slot">Add further Slot</a>
	</div>
	<input type="submit" name="save" value="Senden">
</form>
		 
		