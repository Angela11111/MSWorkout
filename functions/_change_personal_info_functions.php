<?php

function password_change($user_id, $new_password){
	global $database_connection;

	$user_id = clean_variable($user_id);
	$change_password_query = mysqli_query($database_connection, "UPDATE users SET password = '" . sha1($new_password) . "' WHERE id = '" . $user_id ."';");

	if($change_password_query){
		error_notice("You just changed your password!");
	}
	else{
		error_notice("There has been a mistake. The password was not changed.");
	}
}

function email_change($user_id, $new_email){
	global $database_connection;

	$user_id = clean_variable($user_id);
	$change_email_query = mysqli_query($database_connection, "UPDATE users SET email = '" . $new_email . "' WHERE id = '" . $user_id ."';");

	if($change_email_query){
		error_notice("You just changed your email!");
	}
	else{
		error_notice("There has been a mistake. The email was not changed.");
	}
}

function name_change($user_id, $new_name){
	global $database_connection;

	$user_id = clean_variable($user_id);
	$change_name_query = mysqli_query($database_connection, "UPDATE users SET name = '" . $new_name . "' WHERE id = '" . $user_id ."';");

	if($change_name_query){
		error_notice("You just changed your name!");
	}
	else{
		error_notice("There has been a mistake. The name was not changed.");
	}
}

function surname_change($user_id, $new_surname){
	global $database_connection;

	$user_id = clean_variable($user_id);
	$change_surname_query = mysqli_query($database_connection, "UPDATE users SET surname = '" . $new_surname . "' WHERE id = '" . $user_id ."';");

	if($change_surname_query){
		error_notice("You just changed your surname!");
	}
	else{
		error_notice("There has been a mistake. The surname was not changed.");
	}
}

function update_personal_info($user_id, $info){
	if(update_check_requirements($info)){
		
		global $database_connection;

		$clean_info = ["name" => "", "surname" => "", "email" => ""];
		if(isset($info["password"])){
			$clean_info = ["password" => ""];
		}

		$query_string = '';

		foreach ($info as $key => $value) {
			$value = clean_variable($value);
			if($key == "password"){
				$value = sha1($value);
			}
			$query_string .= $key . "='" . $value ."', ";
		}
		$query_string = trim($query_string, ", ");

		$update_info_query = mysqli_query($database_connection, "UPDATE users SET ". $query_string . " WHERE id = '" .$user_id ."';");

		if($update_info_query){
			error_notice("Sucessfully updated!");
			$_SESSION["user"] = $user_id;
			$keys = array_keys($info);
			foreach($keys as $key) {
			 	$_SESSION["user_details"][$key] = $info[$key];
			}
		}
		else{
			error_notice("The personal info could not be updated. Try again.");
			
		}
	}
	else{
		error_notice("The data you enetered is invalid. Please follow the instructions and try again.");
		
	}

}

function update_check_requirements($variables){
	if(isset($variables["password"])){
		return not_null_requirement(["password" => $variables["password"], "name" => $variables["name"], "surname" => $variables["surname"], "email" => $variables["email"]]) and
			min_lenght_requirement(["password" => $variables["password"]], 6) and
			alphabetical_requirement(["name" => $variables["name"], "surname" => $variables["surname"]]);
	}
	else{
		return not_null_requirement(["name" => $variables["name"], "surname" => $variables["surname"], "email" => $variables["email"]]) and
			alphabetical_requirement(["name" => $variables["name"], "surname" => $variables["surname"]]);

	}

}


function upload_picture_temp($max_size = 5000000){

	$picture  = $_FILES["profile_pic"];
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

function finish_image_upload($picture_new_name){
	
	update_profile_picture($picture_new_name);

}

function update_profile_picture($dest){
	global $database_connection;

	$dest = clean_variable($dest);
	$update_pic_query = mysqli_query($database_connection, "UPDATE users SET image_location = '" .$dest ."' WHERE id ='" . $_SESSION["user"] . "'");

	$_SESSION["user_details"]["image_location"] = $dest;

}
?>