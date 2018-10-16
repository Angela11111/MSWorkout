<?php


//GENERATES LOG IN OR SIGN UP FORM
function generate_log_form($type = 'login'){ //it's the same class for the css
	$log = "login";
	$log_text = "Log in";
	if(strstr($type, "up")){
		$log_text = "Sign up";
		$log = "signup";
	}
	$form = '   <a href="home.php" class="back_link"><span class="back_link-glyphicon"></span>Go back home</a>

				<form action="#" method="post" class="col-sm-5 col-sm-offset-1 '. $log . '_form">
				  <header class="'.$log .'_form-title"> '. $log_text .' with your email </header>
				  <div class="form-group">
				    <label for="email" hidden="true">Email address:</label>
				    <input type="email" class="form-control" id="email" name="'. $log . '_email" placeholder="Email adress">
				  </div>
				  <div class="form-group">
				    <label for="pwd" hidden="true">Password:</label>
				    <input type="password" class="form-control" id="pwd" name="'. $log . '_password" placeholder="Password">
				  </div>
				  <a class="'. $log .'_form-forgot_password_link">Forgot password?</a>

				  <input type="hidden" name="action" value="log_in">

				  <button type="submit" class="btn '. $log .'_form-btn_login">'. $log_text . '</button>

				  <a class="'. $log .'_form-signup_link">Not a member? Sign up here.</a>

				</form>

				<div class="col-sm-5 social_login">
					<header class="social_'. $log .'-title"> Or '. $log_text .' with your social media </header>

					<button class="btn social_'. $log .'-btn social_login-btn--with_facebook"> Log in with Facebook</button>

					<button class="btn social_'. $log .'-btn social_login-btn--with_twitter"> Log in with Twitter</button>

					<button class="btn social_'. $log .'-btn social_login-btn--with_google"> Log in with Google</button>

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

	$find_user = mysqli_query($database_connection, "SELECT * from users where email = '" . $email . "' and password = '" . $password . "';");
	if($row = mysqli_fetch_array($find_user, MYSQLI_ASSOC)){

		//unset($row["password"]);
		$_SESSION["user"] = $row["id"];

		//unset($row["id"]);
		$_SESSION["user_details"] = $row;

		//return true;
	}
	else{
		error_notice("Email or password was incorrect.");

		//return false;
	}

	//namesto return kje proveruva dali e setiran session[user]
}
function log_out(){
	unset($_SESSION["user"]);
	unset($_SESSION["user_details"]);
}
?>