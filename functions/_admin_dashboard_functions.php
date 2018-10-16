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

function add_new_program($program){
	
}
?>