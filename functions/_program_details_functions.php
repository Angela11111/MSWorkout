<?php

function generate_location_items($locations){
	//$locations = get_locations();
	$options = '';
	foreach ($locations as $location) {
		$options .= "<option class='location' name='locations_of_program[]' value='" . $location["location_id"] . "' >". $location["full_adress"] . "</option>";
	}

	return $options ;
}

?>