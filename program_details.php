<?php 
	
	include "functions.php"; 
	
	get_programs();
	$program_id = $_GET["program_id"];
	$locations = get_locations($program_id);
	$_SESSION["programs"][$program_id]["locations"] = $locations;
	$options = generate_location_items($_SESSION["programs"][$program_id]["locations"]);

	if(isset($_GET["program_in_location_id"])){
		$program_in_location_id = isset($_GET["program_in_location_id"]) ? $_GET["program_in_location_id"]:'';
		$members = get_program_members($program_in_location_id); 
		$program_location = ($program_in_location_id == '') ? '': get_program_location($program_in_location_id);
		$content = '<div class="container page_content">
				<div class="site_name">
					<h1>
						' . $_SESSION["programs"][$program_id]["name"] . '
					</h1>
					<h4>
						' . $program_location . '
					</h4>
				</div>

				<section class="participants">
					<header class="participants-title">
						<h3>participants</h3>
						<h5 class="participants-title--number_of">
							'. get_number_participants($program_id) . '
						 	participants
						</h5>
					</header>

					<div class="participants-container row">
						'. generate_member_items($members) . '
					</div>
				</section>

				<hr>

				<section class="posts">
					<header class="posts-title">
						<h3>posts</h3>
					</header>
					<button class="btn alt_btns posts-btn_post" data-toggle="modal" data-target="#myModal">
						Write a post
					</button>

					<div class="posts-list"> 
							'. generate_post_items(get_program_posts($program_id)) . '
					</div>

					<!-- data model(write a post) -->
					<div class="modal fade" id="myModal" role="dialog">
					    <div class="modal-dialog modal-lg">
					     	<form action="#" method="post">	
					     		<div class="modal-content post_modal">
								    <div class="modal-header post_modal-header">
								        <button type="button" class="close" data-dismiss="modal">&times;</button>
								        <h4 class="modal-title posts-title">Write a post</h4>
								    </div>
								    <div class="modal-body post_align">
								    	<div>
											<div class="form-group">
												<label for="post_modal-title" hidden="true">Post title:</label>
												<input type="text" class="form-control post_modal-title" id="post_modal-title" name="new_post_title" placeholder="Title">
											</div>

											<div class="form-group">
											    <label for="post_modal-content" hidden="true">Content:</label>
											    <textarea class="form-control post_modal-content" id="post_modal-content" name="new_post_content" placeholder="Write something"></textarea>
											</div>
										</div>

								    	<button class="add_post_picture btn default_btns">Add a photo</button>
									</div>
								
								    <div class="modal-footer post_align post_modal-footer">
								    	<input type="hidden" name="action" value="submit_post">
								    	<button type="submit" class="publish_post btn default_btns">post</button>
								        <button type="button" class="btn alt_btns" data-dismiss="modal">Close</button>
								    </div>
								</div>
					     	</form>
						</div>
					</div>


				</section>

				<hr>


				<section class="photo_gallery">
					<header class="photo_gallery-title">
						<h3>our photo jorney</h3>
					</header>
					<div class="photo_gallery-images">
						'. generate_program_gallery_items($program_id) . '
					</div>
				</section>
			</div>	';

	}
	else{
		$content = '<div class="container site_content">
					<a href="home.php" class="back_link"><span class="back_link-glyphicon"></span>Back to all programs</a>

					<div class="col-sm-10 col-sm-offset-1 featured_image"></div>

					<article class="col-sm-8 col-sm-offset-2 program_details">
							<header class="program_details-name">
								<h2>
									'. $_SESSION["programs"][$program_id]["name"] .'
								</h2>
							</header>

							<p class="program_details-description">
								'. $_SESSION["programs"][$program_id]["description"] .'

							</p>
							<div class="program_details-spaces_available">
								<span class="program_details-spaces_available--glyphicon"></span>
								Available for 20 more people!
							</div>
					</article>

					<div class="col-sm-6 col-sm-offset-3 form-group program_details-location_selection">
						<select class="form-control locations" id ="select_locations">
						  	'. $options .'
					  	</select>
					  <button class="btn btn-lg program_details-sign_up" type="submit" title="Sign up for program"> Sign up</button>
					</div>
				</div>';
	}
	include "template.php";
?>


