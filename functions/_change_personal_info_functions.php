<?php

function password_change($user_id, $new_password){
	global $database_connection;

	$user_id = clean_variable($user_id);
	$change_password_query = mysqli_query($database_connection, "UPDATE users SET password = '" . $new_password . "' WHERE id = '" . $user_id ."';");

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

		$clean_info = ["name" => "", "surname" => "", "email" => "", "password" => ""];
		foreach ($info as $key => $value) {
			$clean_info[$key] = clean_variable($value);
		}
		$update_info_query = mysqli_query($database_connection, "UPDATE users SET name = '" . $clean_info["name"] . "',  surname = '" . $clean_info["surname"] . "', email = '" . $clean_info["email"] ."', password = '" . $clean_info["password"] ."' WHERE id = '" .$user_id ."';");

		if($update_info_query){
			error_notice("Sucessfully updated!");
			$_SESSION["user"] = $user_id;
			$keys = array_keys($clean_info);
			foreach($keys as $key) {
			 	$_SESSION["user_details"][$key] = $clean_info[$key];
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
	return not_null_requirement(["password" => $variables["password"], "name" => $variables["name"], "surname" => $variables["surname"], "email" => $variables["email"]]) and
		min_lenght_requirement(["password" => $variables["password"]], 6) and
		alphabetical_requirement(["name" => $variables["name"], "surname" => $variables["surname"]]);

}
?>