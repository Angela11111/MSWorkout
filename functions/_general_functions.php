<?php
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

function get_company_details(){
	if(!isset($_SESSION["company"])){
		global $database_connection;

		$company_query = mysqli_query($database_connection, "SELECT * FROM company");
		$company = mysqli_fetch_array($company_query);
		$_SESSION["company"] = $company;
	}
}


function get_page_content($page){
	global $database_connection;

	$page = trim(mysqli_real_escape_string($database_connection, $page));
	$page_query = mysqli_query($database_connection, "SELECT * FROM pages_content WHERE page_title = '" . $page ."'");
	$page = mysqli_fetch_array($page_query);
	
	return $page["content"];
}



function error_notice($error = '', $action="add"){
	global $errors;
	// $output_errors ='';
	// print("errors before add");
	// var_dump($errors);
	if($action == "get"){

		// if($errors != []){
		// 	foreach ($errors as $error) {
		// 		$output_errors .= "<div style='color:red'>" . $error . "</div>";
		// 	}
		// }
		//unset($output_errors);
		return $errors;

	}

	else{	
		if($errors == ''){
			$errors = $error;
		}
		else{
			$errors .= $error;
		}
	}

}

function get_locations($program){ //of a program
	global $database_connection;

	$program = trim(mysqli_real_escape_string($database_connection, $program)); //$_GET["get_program"]

	$get_locations_query = mysqli_query($database_connection, "SELECT l.full_adress, l.max_members, location_id from programs_locations pl, locations l where program_id = '" . $program . "' and pl.location_id = l.id"); 
	while($location = mysqli_fetch_array($get_locations_query)){
		$location_id = $location["location_id"];
		
		$locations[$location_id] = $location;
	}

    $_SESSION["programs"][$program]["locations"] = $locations;
	return $locations;
}

function get_all_locations(){ //of a program
	global $database_connection;

	$get_all_locations_query = mysqli_query($database_connection, "SELECT * from locations"); 
	while($location = mysqli_fetch_array($get_all_locations_query)){
		$location_id = $location["id"];
		
		$locations[$location_id] = $location;
	}

	return $locations;
}

function get_programs(){
	global $database_connection;

	$programs_query = mysqli_query($database_connection, "SELECT * FROM programs");

	while ($program = mysqli_fetch_array($programs_query, MYSQLI_ASSOC)) {
		$program_id = $program["id"];
		// $program["locations"] = get_locations($program_id);
		//unset($program["id"]);
		$_SESSION["programs"][$program_id] = $program;
	}


}

function get_program_location_id($program_id, $user_id){
	global $database_connection;

	$program_id = trim(mysqli_real_escape_string($database_connection, $program_id));
	$user_id = trim(mysqli_real_escape_string($database_connection, $user_id));
	$pl_query = mysqli_query($database_connection, "SELECT programs_locations.id as id FROM members, programs_locations WHERE members.user_id = '" . $user_id . "' and programs_locations.program_id = '" . $program_id ."' and members.program_in_location= programs_locations.id");
	$pl_id = mysqli_fetch_array($pl_query, MYSQLI_ASSOC);
	return $pl_id["id"];
}

function clean_variable($variable){
	global $database_connection;
	return trim(mysqli_real_escape_string($database_connection, $variable));
}

function not_null_requirement($variables){
	$flag = TRUE;
	foreach ($variables as $key => $value) {
		if(!$value){
			error_notice("The " . $key . " field can not be empty.");
			$flag = FALSE;
		}
	}

	return $flag;
}

function alphabetical_requirement($variables){
	$flag = TRUE;
		foreach ($variables as $key => $value) {
			if(!ctype_alpha($value)){
				error_notice("The " . $key . " field must only contain letters.");
				$flag = FALSE;
			}
		}

	return $flag;
}

function alphanumeric_requirement($variables){
	$flag = TRUE;
		foreach ($variables as $key => $value) {
			if(!ctype_alnum($value)){
				error_notice("The " . $key . " field must only contain letters and/or numbers.");
				$flag = FALSE;
			}
		}

	return $flag;
}

function numeric_requirement($variables){
	$flag = TRUE;
		foreach ($variables as $key => $value) {
			if(!is_numeric($value)){
				error_notice("The " . $key . " field must only contain numbers.");
				$flag = FALSE;
			}
		}

	return $flag;
}

function min_lenght_requirement($variables, $min_size){
	$flag = TRUE;
	//var_dump($variables);
		foreach ($variables as $key => $value) {
			if(strlen($value) < $min_size){
				error_notice("The " . $key . " field must be at least " . $min_size . "characters long.");
				$flag = FALSE;
			}
		}

	return $flag;
}


function upload_picture_temp($name_file, $max_size = 5000000){
	$picture  = $_FILES[$name_file];
	$picture_name = $picture["name"];
	$picture_temp_location = $picture["tmp_name"];
	$picture_type = $picture["type"];
	$picture_size = $picture["size"];
	$error = $picture["error"];

	$picture_name_ext = explode(".", $picture_name);
	$picture_actual_ext = trim(strtolower(end($picture_name_ext)));

	$allowed = ["jpg", "jpeg", "gif", "png"];

	if(in_array($picture_actual_ext, $allowed)){

		if($error === 0){

			if($picture_size < $max_size){

				$picture_new_name = uniqid('', true) . "." . $picture_actual_ext;
				move_uploaded_file($picture_temp_location, $picture_new_name);
				return $picture_new_name;
			}
			else{
				error_notice("Size too big");
			}
		}
		else{
			error_notice("Error in image " );
			var_dump($picture);
		}
	}
	else{
		error_notice("not allowed extension");
	}
	
}


?>