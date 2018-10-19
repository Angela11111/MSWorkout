<?php

function get_all_users(){
	global $database_connection;

	$all_useres_query = mysqli_query($database_connection, "SELECT * FROM users");
	$users = [];
	while($user = mysqli_fetch_array($all_useres_query, MYSQLI_ASSOC)){
		$users[$user["id"]] = $user;
	}
	return $users;
}

function generate_users(){
	global $database_connection;
	$users = get_all_users();

	$output ='';
	//$user_users =  $_SESSION["user_in_users"];


	foreach ($users as $user) {
		$programs = get_user_programs($user["id"]);
		$programs_string ='';
		foreach ($programs as $program) {
			$programs_string .= '<div class="all_users-content--user-details">
						   			<span class="all_users-content--user-details--item">
						   				' . $program["name"] . '
							   		</span>
						   		</div>';
		}
		$output .= '<div  class="all_users-content--user" id="'. $user["id"] . '">
				   		<span class="all_users-content--user-name">
				   			' . $user["name"] . '
				   		</span>
				   		<button class="btn default_btns all_users-content--user-delete_btn">Delete</button>
				   		' . $programs_string .'
				   </div>';
	}

	return $output;
}

function all_programs(){
	if(!isset($_SESSION["programs"])){
		get_programs();
	}
	$programs = $_SESSION["programs"];
	$output = '';

	foreach ($programs as $program) {

		$program_locations = get_locations($program["id"]);
		$locations = [];
		foreach ($program_locations as $location) {
			$locations[] = $location["full_adress"];
		}

		$output .= '<a class="user_programs-content--program">
				   		<span class="user_programs-content--program-name">
				   			' . $program["name"] . '
				   		</span>
				   		<div class="user_programs-content--program-details">
					   		<span class="user_programs-content--program-details--item">
					   			' . implode(", ", $locations) . '
					   		</span>
				   		</div>
				   </a>';
	
	}
	return $output;
}
function check_requirements_program($inputs){
	return not_null_requirement(["name" => $inputs["name"], "description" => $inputs["description"], "price" => $inputs["price"], "currency" => $inputs["currency"]]);
}
function add_new_program(){
	global $database_connection;
	$table_keys = ["name", "description", "price", "currency", "date_created", "image", "featured"]; 

	$program_locations = $_REQUEST["new_program_locations"]; //FALI MAX MEMBERS
	$max_members = $_REQUEST["new_program_max_members"];

	foreach ($table_keys as $key) {
		if(isset($_REQUEST["new_program_" . $key])){
			$inputs[$key] = clean_variable($_REQUEST["new_program_" . $key]);
		}
	}

	check_requirements_program($inputs); //ako ne e setirana ni edna lokacija kje si izvadi null

	$new_location_image = upload_picture_temp("new_program_image"); //general_functions
	$inputs["program_image"] = $new_location_image;
	
	unset($inputs["image"]);
	$inputs["date_created"] = date("Y-m-d");
	$inputs["featured"] = (isset($inputs["featured"])) ? 1:0;
	// $var = "INSERT INTO programs(" . implode(",", array_keys($inputs)) .") VALUES ('" . implode("','", $inputs) . "');";
	// print($var);

	$insert_program_query = mysqli_query($database_connection, "INSERT INTO programs(" . implode(",", array_keys($inputs)) .") VALUES ('" . implode("','", $inputs) . "');");
	$inserted_program_id = mysqli_insert_id($database_connection);
	
	insert_program_locations($inserted_program_id, $program_locations, $max_members);

}

function insert_program_locations($program_id, $program_locations, $max_members){
	global $database_connection;

	$all_locations = get_all_locations(); //FALI MAX MEMBERS

	foreach ($all_locations as $location) {
		if(in_array($location["full_adress"], $program_locations)){
			$program_locations_query = mysqli_query($database_connection, "INSERT INTO programs_locations(program_id, location_id) VALUES('" . $program_id . "', '" . $location["id"] . "');");
			unset($program_locations[key($location)]);
		}
	}
	if($program_locations != []){
		foreach ($program_locations as $key => $pl) {
			//print("The index of the program location that will be used to access mex members is: " . $key);
			$new_location_id = insert_new_location($pl, $max_members[$key]);
			$program_locations_query = mysqli_query($database_connection, "INSERT INTO programs_locations(program_id, location_id) VALUES('" . $program_id . "', '" . $new_location_id . "');");
			if(!$program_locations_query){
				var_dump("Query not working");
			}
		}
	}

}

function insert_new_location($adress, $max_members){
	global $database_connection;

	$insert_location_query = mysqli_query($database_connection, "INSERT INTO locations(full_adress, max_members) VALUES('" . $adress . "', '" . $max_members . "');");
	if($insert_location_query){
		return mysqli_insert_id($database_connection);
	}
	else{
		error_notice("The location " . $adress . " could not be added to the database.");
		return FALSE;
	}
}

?>