<?php
include "functions.php";
//log_in("angelaa@yahoo.com","angela1");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$content = '<div class="container page_content">
				<div class="site_name">
					<h1>My account</h1>
				</div>

				<form action="#" method="post" class="col-sm-6 col-sm-offset-3 change_info_form">

					<header class="change_info_form-title">
						<h3>Change my personal info</h3>
					</header>

					<div class="form-group">
					   <label for="change_person_name" hidden="true">First and last name:</label>
					   <input type="text" class="form-control change_personal_info_control" id="change_person_name" name="update_name_surname" placeholder="First and last name" value="' . $_SESSION["user_details"]["name"] . " " . $_SESSION["user_details"]["surname"] . '" >
					</div>

					<header class="change_info_form-change_instructions">To change your email adress or password, you need to confirm your current password</header>

					<div class="form-group">
					  <label for="change_curr_pwd" hidden="true">Current password:</label>
					  <input type="text" class="form-control change_personal_info_control" id="change_curr_pwd" name="current_password" placeholder="Current password" >
					</div>
					<div class="form-group">
					  <label for="change_email" hidden="true">Email adress:</label>
					  <input type="email" class="form-control change_personal_info_control" id="change_email" name="update_email" placeholder="Email adress" value="' . $_SESSION["user_details"]["email"] . '" >
					</div>
					<div class="form-group">
					  <label for="change_newpwd" hidden="true">New password:</label>
					  <input type="password" class="form-control change_personal_info_control" id="change_new_pwd" name="update_password-new" placeholder="New password">
					</div>
					<div class="form-group">
					  <label for="change_confirm_new_pwd" hidden="true">Confirm new password:</label>
					  <input type="password" class="form-control change_personal_info_control" id="change_confirm_new_pwd" name="update_password-new_confirm" placeholder="Confirm new password">
					</div>


					<div class="change_info_form-profile_picture_section">
						<header class="change_info_form-change_instructions">Profile picture</header>
						<div class="change_info_form-profile_picture_section--profile_picture" name="update_profile_pic" style="background-image: url(\'' . $_SESSION["user_details"]["image_location"] . '\'")); >
								
						</div>

						<button class="btn change_info_form-profile_picture_section--picture_change_btn  default_btns">change</button>
						<button class="btn change_info_form-profile_picture_section--picture_remove_btn  default_btns">remove</button>

					</div>
					<input type="hidden" name="action" value="save_changes_profile">
					<button type="submit" class="btn change_info_form-btn_save alt_btns">Save changes</button>
					<button type="submit" class="btn default_btns">Cancel</button>

				</form>
			</div>	';
include "template.php";

?>
