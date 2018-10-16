<?php

include "database_connection.php";
include "functions/_general_functions.php";
include "functions/_home_functions.php";
include "functions/_log_functions.php";
include "functions/_profile_functions.php";
include "functions/_program_details_functions.php";
include "functions/_program_details_member_functions.php";
include "functions/_change_personal_info_functions.php";
include "functions/_admin_dashboard_functions.php";


//USER PROFILE - USER MEMBER OF PROGRAMS:



//get_program_available_places($program_id, option.selected["location_capacity"]);




// function get_members($program_id){ //TRHOUGH SESSION
// 	global $database_connection;

// 	$program_id = trim(mysqli_real_escape_string($database_connection, $program_id));
// 	$members_query = mysqli_query($database_connection, "SELECT * FROM members WHERE program_id = '" . $program_id . "'");
// 	while($member = mysqli_fetch_array($members_query)){
// 		$member_id = $member["id"];
// 		unset($member["id"]);

// 		$members[$member_id] = $member;
// 	}
// 	return $members;
// }



// function get_program_available_places($program_id, $location_id){ 

// 	$taken = (int)get_members_at_location($program_id, $location_id);
		
// 	$maximum_places = (int)$_SESSION["programs"][$program_id]["locations"][$location_id]["max_members"];

// 	$result = $maximum_places - $taken;
// 	$_SESSION["programs"][$program_id]["locations"][$location_id]["available"] = $result;

// 	return $result;
// }

// // get_programs();
// // get_locations();
// // print(get_program_available_places(1, 1));


// function get_members_at_location($program_id, $location_id){
// 	global $database_connection;
// 	$porgram_id = trim(mysqli_real_escape_string($database_connection, $program_id));
// 	$location_id = trim(mysqli_real_escape_string($database_connection, $location_id));

// 	$members_at_location_query = mysqli_query($database_connection, "SELECT count(id) as sum FROM members WHERE program_id = '" . $program_id ."' and location = '" . $location_id ."'");
// 	$number_of_members = mysqli_fetch_array($members_at_location_query);

// 	return $number_of_members["sum"];
// }

// function multiple_locations_available_places($program_id){
// 	if(!isset($_SESSION["programs"][$program_id]["locations"])){
// 		$_SESSION["programs"][$program_id]["locations"] = get_locations($program_id);
// 	}
// 	$locations = $_SESSION["programs"][$program_id]["locations"];
// 	foreach ($locations as $location) {
// 		if(!isset($location["available"])){
// 			$location_id = key($location);
// 			$_SESSION["programs"][$program_id]["locations"][$location_id]["available"] = get_program_available_places($program_id, $location_id);
// 		}
// 	}
// }

?>
