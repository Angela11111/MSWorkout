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
					  <h2>all programs</h2>
					  <h5> there are: ' . sizeof($_SESSION["programs"]) . '</h5>
					 </div>
					 <div class="user_programs-add_new">
					 	<button class="btn alt_btns user_programs-add_new-btn" data-toggle="modal" data-target="#modalNewProgram">add a new program</button>
					 </div>
					 <div class="user_programs-content">
					   ' . all_programs() .'
					 </div>
				</section>

				<hr>

				<section class="all_users">

					 <div class="all_users-title">
					  <h2>all members</h2>
					 </div>

					 <div class="all_users-content">
					   ' . generate_users() .'
					 </div>
					 <div class="all_users-content--goto_all_programs">
							<a href="home.php" class="btn all_users-content--goto_all_programs-btn">
								explore all programs
							</a>
					</div>
				</section>
			</div>

			<div class="modal fade" id="modalNewProgram" role="dialog">
			    <div class="modal-dialog">
			    
			      <!-- Modal content-->
			      <div class="modal-content">
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 class="modal-title">New program</h4>
			        </div>
			        <div class="modal-body">
			          <form action="/action_page.php">
			          		<div class="form-group">
								<label for="program_modal-name" hidden="true">Program name:</label>
								<input type="text" class="form-control program_modal-name" id="program_modal-name" name="new_post_title" placeholder="Name">
							</div>

							<div class="form-group">
								<label for="program_modal-description" hidden="true">Content:</label>
								<textarea class="form-control program_modal-description" id="program_modal-description" name="new_post_content" placeholder="Write description"></textarea>
							</div>

							<div class="form-group">
								<label for="program_modal-price" hidden="true">Price:</label>
								<input type="text" class="form-control program_modal-price" id="program_modal-price" name="new_post_title" placeholder="Price">
							</div>

							<div class="form-group">
								<label for="program_modal-currency" hidden="true">Currency:</label>
								<input type="text" class="form-control program_modal-currency" id="program_modal-urrency" name="new_post_title" placeholder="Currency">
							</div>
							<div class="form-group">
							    <label>Featured: </label>
							    <input type="checkbox">
							</div>

							<hr>

							<div class="form-group">
								<label for="program_modal-locations">Locations:</label>
								<input type="text" class="form-control program_modal-locations" id="program_modal-locations" name="new_program_locations" placeholder="Location">
							</div>
							<div class="form-group">
								<label for="program_modal-locations" hidden="true">Locations:</label>
								<input type="text" class="form-control program_modal-locations" id="program_modal-locations" name="new_program_locations" placeholder="Location">
							</div>
							<div class="form-group">
								<label for="program_modal-locations" hidden="true">Locations:</label>
								<input type="text" class="form-control program_modal-locations" id="program_modal-locations" name="new_program_locations" placeholder="Location">
							</div>

					    <button type="submit" class="btn btn-default">Submit</button>
					  </form>
			        </div>
			         

			        <div class="modal-footer">
			          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        </div>
			      </div>
			      
			    </div>
			  </div>
			  
			</div>';
include "template.php";
?>
