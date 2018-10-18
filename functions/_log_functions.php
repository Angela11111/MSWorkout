<?php


//GENERATES LOG IN OR SIGN UP FORM
function generate_log_form($type = 'login'){ //it's the same class for the css
	$log = "login";
	$log_text = "Log in";
	$additional = '<a class="'. $log .'_form-forgot_password_link">Forgot password?</a>
				   <a class="'. $log .'_form-signup_link" href="signup.php">Not a member? Sign up here.</a>';
	if(strstr($type, "up")){
		$log_text = "Sign up";
		$log = "signup";
		$additional = '<div class="form-group">
					    <label for="confirm_password" hidden="true">Confirm password:</label>
					    <input type="text" class="form-control '. $log . '_form-inputs" id="confirm_password" name="'. $log . '_confirm_password" placeholder="Confirm password">
					  </div>
					  <div class="form-group">
					    <label for="name" hidden="true">Name:</label>
					    <input type="text" class="form-control '. $log . '_form-inputs" id="name" name="'. $log . '_name" placeholder="Name">
					  </div>
					  <div class="form-group">
					    <label for="surname" hidden="true">Surname:</label>
					    <input type="text" class="form-control '. $log . '_form-inputs" id="surname" name="'. $log . '_surname" placeholder="Surname">
					  </div>
					  <div class="form-group">
					    <label for="birth_date" hidden="true">Birth date:</label>
					    <input type="text" class="form-control '. $log . '_form-inputs" id="birth_date" name="'. $log . '_birth_date" placeholder="Birth date">
					  </div>
					  <div class="form-group">
					    <label for="credit_card_number" hidden="true">Credit card number:</label>
					    <input type="text" class="form-control '. $log . '_form-inputs" id="credit_card_number" name="'. $log . '_credit_card_number" placeholder="Credit card number">
					  </div>
					  <a class="login_form-signup_link" href="login.php">Already a member? Sign in here.</a>';
	}
	$form = '   <a href="home.php" class="back_link"><span class="back_link-glyphicon"></span>Go back home</a>

				<form action="#" method="post" class="col-sm-5 col-sm-offset-1 '. $log . '_form">
				  <header class="'.$log .'_form-title"> '. $log_text .' with your email </header>
				  <div class="form-group">
				    <label for="email" hidden="true">Email address:</label>
				    <input type="email" class="form-control '. $log . '_form-inputs" id="email" name="'. $log . '_email" placeholder="Email adress">
				  </div>
				  <div class="form-group">
				    <label for="pwd" hidden="true">Password:</label>
				    <input type="password" class="form-control '. $log . '_form-inputs" id="pwd" name="'. $log . '_password" placeholder="Password">
				  </div>
				  
				  '. $additional . '
				  <input type="hidden" name="action" value="' . $log . '">

				  <button type="submit" class="btn '. $log .'_form-btn_submit">'. $log_text . '</button>

				  

				</form>

				<div class="col-sm-5 social_'. $log .'">
					<header class="social_'. $log .'-title"> Or '. $log_text .' with your social media </header>

					<button class="btn social_'. $log .'-btn social_'. $log .'-btn--with_facebook"> Log in with Facebook</button>

					<button class="btn social_'. $log .'-btn social_'. $log .'-btn--with_twitter"> Log in with Twitter</button>

					<button class="btn social_'. $log .'-btn social_'. $log .'-btn--with_google"> Log in with Google</button>

				</div>';
			return $form;
} //TODO NAPRAI DA DODAVA POLINJA ZA SIGN UP


function get_log_form(){
	return generate_log_form($_GET["log_form"]); // kje ima a tag/s so href log_form = "signin" ili "signup"
}

//GETS USER LOGGED IN AND SETS SESSION VARIABLES FOR USER
function log_in($email, $password){ //ovie kje se zemaat od $_POST i koa kje se vidi deka action = login kje se povika funkcijava
	global $database_connection;

	$email = trim(mysqli_real_escape_string($database_connection, $email));
	$password = trim(mysqli_real_escape_string($database_connection, $password));

	$find_user = mysqli_query($database_connection, "SELECT * from users where email = '" . $email . "' and password = '" . sha1($password) . "';");
	if($row = mysqli_fetch_array($find_user, MYSQLI_ASSOC)){

		//unset($row["password"]);
		$_SESSION["user"] = $row["id"];

		//unset($row["id"]);
		$_SESSION["user_details"] = $row;

		//return true;
		error_notice("Succesfully logged in");
	}
	else{
		error_notice("Email or password was incorrect.");

		//return false;
	}
	var_dump(error_notice("","get"));
	//namesto return kje proveruva dali e setiran session[user]
}
function log_out(){
	unset($_SESSION["user"]);
	unset($_SESSION["user_details"]);
}


function sign_up_check($user_data){
	return not_null_requirement(["name" => $user_data["name"], "surname" => $user_data["surname"], "email" => $user_data["email"], "password" => $user_data["password"], "birth_date" => $user_data["birth_date"], "credit_card_number" => $user_data["credit_card_number"]])
		and	alphabetical_requirement(["name" => $user_data["name"], "surname" => $user_data["surname"]])
		and numeric_requirement(["credit_card_number" => $user_data["credit_card_number"]])
		and min_lenght_requirement(["password" => $user_data["password"]], 6);

}

function sign_up($user_data){
	global $database_connection;

	if(sign_up_check($user_data)){
		foreach ($user_data as $key => $value) {
			$user_data["key"] = clean_variable($value);
		}

		$keys = ["name", "surname", "email", "credit_card_number", "password", "birth_date"];
	
		$signup_query = mysqli_query($database_connection, "INSERT INTO users(name, surname, email, password, birth_date, credit_card_number, image_location, created_on_date) VALUES('". $user_data["name"] . "', '" . $user_data["surname"] . "', '" . $user_data["email"] . "', '" . sha1($user_data["password"]) . "', '" .$user_data["birth_date"] . "', '" . $user_data["credit_card_number"] ."', 'Running.jpg', '" . date('Y-m-d') . "');");

		if(!$signup_query){
			error_notice("There was a mistake. Your data is invalid. Try again.");
			return FALSE;
		}
		return TRUE;
	}
}
?>