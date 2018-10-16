<?php
include "functions.php";
//log_in("angelaa@yahoo.com","angela1");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$content = '<div class="site_content container">
				<div class="site_name">
					<h1>My account</h1>
				</div>
				<section class="personal_info">
					<div class="personal_info-title">
						<h3>
							personal info
						</h3>
					</div>

					<div class="personal_info-content">
						<div class="personal_info-content--profile_picture" style="background-image:url(\'' . $_SESSION["user_details"]["image_location"] .'\')">
							
						</div>

						<div class="personal_info-content--basic_info">
							<label for="person_name" class="personal_info-content--basic_info-labels">
								first and last name
							</label>
							<div id="person_name" class="personal_info-content--basic_info-data">
								' . $_SESSION["user_details"]["name"] . " " . $_SESSION["user_details"]["surname"] .'
							</div>
							<label for="person_email" class="personal_info-content--basic_info-labels">
								email adress
							</label>
							<div id="person_email" class="personal_info-content--basic_info-data">
								' . $_SESSION["user_details"]["email"] .'
							</div>
							<label for="person_joined_date" class="personal_info-content--basic_info-labels">
								Joined on
							</label>
							<div id="person_joined_date" class="personal_info-content--basic_info-data">
								' . $_SESSION["user_details"]["created_on_date"] .'
							</div>
						</div>

						<div class="personal_info-content--goto_edit_profile">
							<a href="change_personal_info.php" class="btn personal_info-content--goto_edit_profile-btn">
								change my personal info
							</a>
						</div>
					</div>
				</section>

				<hr>

				<section class="user_programs">

					 <div class="user_programs-title">
					  <h2>my programs</h2>
					 </div>

					 <div class="user_programs-content">
					   ' . generate_user_programs_items() .'
					 </div>
					 <div class="user_programs-content--goto_all_programs">
							<a href="home.php" class="btn user_programs-content--goto_all_programs-btn">
								explore all programs
							</a>
					</div>
				</section>
			</div>';
include "template.php";
?>
