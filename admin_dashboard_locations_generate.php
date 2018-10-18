<label for="program_modal-locations">Locations:</label>
							<input type="text" placeholder="Number of locations.." name="num_locations">
							<div class="btn btn_default" id="generate_location_inputs">Generate inputs</div>

							<div id="location_inputs_container"></div>
<!-- <script type="text/javascript">
	$("#generate_location_inputs").click(function(){
		var num = $("[name = 'num_locations']").value;
		var content ='';
		for(var i=0; i < num; i++){
			content += '<div class="form-group"><label for="program_modal-currency" hidden="true">Currency:</label><input type="text" class="form-control program_modal-currency" id="program_modal-urrency" name="new_post_title" placeholder="Currency"></div>';
		}

		$("#location_inputs_container").html(content);
		console.log(content);

	})
</script> -->