<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

get_company_details();

if(isset($_SESSION["user"])){
	$user_link = '<a href="#" data-toggle="popover" data-placement="bottom" class="main_menu-link">
		      	'.
			      	$_SESSION["user_details"]["name"] . " " . $_SESSION["user_details"]["surname"]
				.'
		      	<div class="glyphicon glyphicon-user login-glyphicon"></div></a>';
}
else{
	$user_link = '<a href="login.php" class="main_menu-link">
		      	Log in
		      	<div class="glyphicon glyphicon-user login-glyphicon"></div></a>';
}
?>
<html lang="en">

	<head>
		  <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="CSS/styles.css"></link>
		<script type="text/javascript" src="jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="bootstrap-sass-3.3.7/assets/javascripts/bootstrap.js"></script>
	</head>

	<body>
		<nav class="navbar navbar-default main_menu">
		  <div class="container main_menu-container">
		    <div class="navbar-header">
		      <a class="navbar-brand main_menu-company" href="home.php">
		      	<?php
					print($_SESSION["company"]["name"]);
				?>
		      </a>
		    </div>
		    <ul class="nav navbar-nav navbar-right">
		      <li><?php print($user_link);?></li>
		    </ul>
		  </div>
		</nav>  

		<main>
			<?php
				print($content);
			?>
		</main>

		<footer class="site_footer container-fluid">
			<div class="container">
				<div class="site_footer-left pull-left">
					<h3 class="site_footer-left--company">
						<?php
							print($_SESSION["company"]["name"]);
						?>
					</h3>
					<h5 class="site_footer-left--copyright">
						<span class="glyphicon glyphicon-copyright-mark"></span>
						2018
					</h5>
				</div>
				<div class="site_footer-right pull-right">
					<span class="site_footer-right--facebook_glyphicon"></span>
					<span class="site_footer-right--twitter_glyphicon"></span>
				</div>
			</div>
		</footer>


		<div class="data-toggle_links hidden">
			<a class='main_menu-link data-toggle_link' href='profile.php' style="display: block;">See profile</a>
			<a class='main_menu-link data-toggle_link' href='home.php?action=log_out' style="display: block;">Log out</a>
		</div>
					
	</body>
</html>
<?php
	if(isset($_REQUEST["action"])){
		switch ($_REQUEST["action"]) {
			case 'log_in':
				$login_email = $_REQUEST["login_email"];
				$login_password = $_REQUEST["login_password"];
				log_in($login_email, $login_password);

				if(isset($_SESSION["user"])){
					header('Location: profile.php'); 
				}
			break;
			
			case 'log_out':
				log_out();
				header('Location: home.php');
				header("Refresh:0; url=home.php");

			break;

			case 'program_details':
				$program_id = $_REQUEST["program_id"];
				if(isset($_SESSION["user"])){
					
					$programs_locations = get_program_location_id($program_id, $_SESSION["user"]);
					if(get_program_members($programs_locations)[$_SESSION["user"]] != null){
						//var_dump(get_program_members($programs_locations)[$_SESSION["user"]]);
						header('Location: program_details.php?program_id='.$program_id .'&program_in_location_id=' . $programs_locations); 
					}
					else{
						header('Location: program_details.php?program_id='. $program_id); 
					}
				}
				else{
					header('Location: program_details.php?program_id='. $program_id); 
				}
				break;

			case 'submit_post':
				$user= $_SESSION["user"];
				$program_in_location = $_GET["program_in_location_id"];

				$title = $_REQUEST["new_post_title"];
				$content = $_REQUEST["new_post_content"];	

				if($title == '' and $content == ''){
					error_notice("The post title and content should not be empty.");
				}
				else{
					$member = get_member_id($user, $program_in_location);
					var_dump($program_in_location);
					$post = ["member" => $member, "program_in_location" => $program_in_location, "title" => $title, "content" => $content];
					submit_post($post);
						header('Location: program_details.php?program_id='.$program_id .'&program_in_location_id=' . $program_in_location); 

				}
				break;
			case 'save_changes_profile':
				$user= $_SESSION["user"];
				$name_surname = explode(" ", clean_variable($_REQUEST["update_name_surname"]));
				$info = ["name" => $name_surname[0], "surname" => $name_surname[1], "email" => $_REQUEST["update_email"], "password" => $_REQUEST["current_password"]];
				if($_REQUEST["current_password"] != $_SESSION["user_details"]["password"]){
					error_notice("That is not your current password. Please try again.");

				}
				elseif($_REQUEST["update_password-new"] != $_REQUEST["update_password-new_confirm"]){
					error_notice("The passwords you entered do not match. Please try again.");
				}
				else{
					update_personal_info($user, $info);
				}
				

				var_dump(error_notice("", "get"));
			break;
		}
	}
?>

<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({content: $(".data-toggle_link"), html:true});   
});
</script>
