<?php
function get_program_members($program_in_location){
	global $database_connection;

	$program_id = trim(mysqli_real_escape_string($database_connection, $program_in_location));
	$members = [];
	$members_query = mysqli_query($database_connection, "SELECT members.* FROM members WHERE members.program_in_location = '" . $program_in_location . "'" );
	while($member = mysqli_fetch_array($members_query, MYSQLI_ASSOC)){
		$members[$member["user_id"]] = $member;
	}
	return $members;
}

function generate_member_items($members){
	global $database_connection;
	$output = '';

	foreach ($members as $member) {
		$user_member_query = mysqli_query($database_connection, "SELECT name FROM users WHERE id = '" . $member["user_id"] . "'");
		$user_member = mysqli_fetch_array($user_member_query, MYSQLI_ASSOC);
		$output .= '<div class="col-sm-2 participants-container--participant" id="'. $member["user_id"] .'">
						<div class="participants-container--participant-profile_picture">	
						</div>
						<div class="participants-container--participant-name">
							'. $user_member["name"] .'
						</div>
					</div>';
	}

	return $output;
}

function get_program_posts($program_id){
	global $database_connection;

	$program_location_id = trim(mysqli_real_escape_string($database_connection, $program_id));
	$posts_query = mysqli_query($database_connection, "SELECT posts.*, users.name as user_name, users.surname as user_surname FROM posts, members, programs_locations, users WHERE members.user_id = users.id and posts.member_id = members.id and members.program_in_location = programs_locations.id and programs_locations.program_id = '" . $program_id ."'");
	$posts = [];
	while($post = mysqli_fetch_array($posts_query, MYSQLI_ASSOC)){
		$posts[] = $post;
	}

	return $posts;
}

function generate_post_items($posts){
	$output = '';

	foreach ($posts as $post) {
		$output .= '<div class="container-fluid posts-list--post" id="' . $post["id"] . '">
						<h4 class="posts-post-list--post-title">
							' . $post["post_title"] . '
						</h4>

						<p class="participants-title--number_of"> '. $post["user_name"] . " " . $post["user_surname"] . '
						<p>
							' . $post["post_text"] . '
						</p>

						'. generate_post_images(get_post_images($post["id"])) .'
					</div>'; //smeni ja klasata na p name i surname
	}
	return $output;
}

function get_post_images($post_id){
	global $database_connection;

	$images_query = mysqli_query($database_connection, "SELECT * FROM post_images WHERE post_id = '" . $post_id . "'");
	$images =[];
	while($image = mysqli_fetch_array($images_query, MYSQLI_ASSOC)){
		$images[] = $image;
	}

	return $images;
}

function generate_post_images($images){
	$output = '';

	foreach ($images as $image) {
		$output .= '<div class="col-sm-2 posts-list--post-picture" id="'. $image["id"] . '" style = "background-image: url(\''.$image["image_url"].'\');" title = "'. $image["image_title"] .'">
							
						</div>';
	}
	return $output;
}

function get_program_gallery($program_in_location){
	global $database_connection;

	$program_in_location = trim(mysqli_real_escape_string($database_connection, $program_in_location));
	$gallery_query = mysqli_query($database_connection, "SELECT post_images.* FROM post_images, posts, members WHERE post_images.post_id = posts.id and posts.member_id = members.id and members.program_in_location = '" . $program_in_location ."'");
	$gallery = [];
	if($gallery_query){
		while($image = mysqli_fetch_array($gallery_query, MYSQLI_ASSOC)){
			$gallery[] = $image;
		}
	}
	return $gallery;

}


function generate_program_gallery_items($program_id){
	$gallery = get_program_gallery($program_id);
	$output = '';
	foreach ($gallery as $image) {
		$output .= '<div class="photo_gallery-images--image_container col-sm-2">
						<div class="photo_gallery-images--image" id="'. $image["id"] .'" style="background-image: url(\''. $image["image_url"] .'\');" alt="' . $image["image_title"] .'">
							
						</div>
					</div>';
	}

	return $output;

}

function get_number_participants($program_id){
	global $database_connection;

	$program_id = trim(mysqli_real_escape_string($database_connection, $program_id));
	$participants_query = mysqli_query($database_connection, "SELECT count(members.id) as count_participants FROM members, programs_locations WHERE members.program_in_location = programs_locations.id and programs_locations.program_id = '" .$program_id . "'");
	$participants = mysqli_fetch_array($participants_query);

	return $participants["count_participants"];
}


function get_program_location($program_in_location_id){
	global $database_connection;
	$program_in_location_id = trim(mysqli_real_escape_string($database_connection, $program_in_location_id));

	$location_query = mysqli_query($database_connection, "SELECT locations.full_adress as full_adress FROM locations, programs_locations WHERE programs_locations.id = '" . $program_in_location_id ."' and  locations.id = programs_locations.location_id");

	$location = mysqli_fetch_array($location_query, MYSQLI_ASSOC);

	return $location["full_adress"];

}
function get_member_id($user, $program_in_location){
	global $database_connection;
	$user_id = trim(mysqli_real_escape_string($database_connection, $user));
	$program_in_location = trim(mysqli_real_escape_string($database_connection, $program_in_location));

	$get_member_id_query = mysqli_query($database_connection, "SELECT id FROM members WHERE members.user_id = '" . $user_id . "' and members.program_in_location ='".$program_in_location ."'");
	$member_id = mysqli_fetch_array($get_member_id_query);
	return $member_id["id"];
}
function submit_post($post){
	global $database_connection;
	$member = trim(mysqli_real_escape_string($database_connection, $post["member"]));

	$title = trim(mysqli_real_escape_string($database_connection, $post["title"]));
	$content = trim(mysqli_real_escape_string($database_connection, $post["content"]));

	var_dump($member);
	var_dump($title);
	var_dump($content);
	$insert_post_query = mysqli_query($database_connection, "INSERT INTO posts(post_text, post_title, posted_on_date, member_id) VALUES('". $content . "','" . $title . "','" . "2018-10-10" . "','" . $member . "');");

	if($insert_post_query){
		//error_notice("You just submited the post!");
		//print("YES");
	}
	else{
		error_notice("The post could not be submited.");
		//print("NO");
	}
}

?>