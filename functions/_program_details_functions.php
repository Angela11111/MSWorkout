<?php

function generate_location_items($locations){
	//$locations = get_locations();
	$options = '';
	foreach ($locations as $location) {
		$options .= "<option class='location' location_id = ". key($location) ." location_capacity= ".$location["max_members"].">". $location["full_adress"] . "</option>";
	}

	return $options ;
}

?>