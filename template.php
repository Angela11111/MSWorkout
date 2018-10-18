<?php
$_SESSION["notices"] = '';
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
		<div id="notices">
			
		</div>

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
			case 'login':
				var_dump("LOGIN");
				$login_email = $_REQUEST["login_email"];
				$login_password = $_REQUEST["login_password"];
				log_in($login_email, $login_password);
				if(isset($_SESSION["user"])){
					header('Location: profile.php'); 
				}

			break;
			
			case 'log_out':
				log_out();

			break;


			case 'submit_post':
				$user= $_SESSION["user"];
				$program_in_location = $_GET["program_in_location_id"];

				$title = $_REQUEST["new_post_title"];
				$content = $_REQUEST["new_post_content"];	
				//$img_titles = $_REQUEST["img_titles"];

				if($title == '' and $content == ''){
					error_notice("The post title and content should not be empty.");
				}
				else{
					$member = get_member_id($user, $program_in_location);
					$post = ["member" => $member, "program_in_location" => $program_in_location, "title" => $title, "content" => $content];
					$submited_post_id = submit_post($post);
					if($submited_post_id){
						$locations = upload_post_images();
						update_posts_table($locations,  $submited_post_id);
					}

						header('Location: program_details.php?program_id='.$program_id .'&program_in_location_id=' . $program_in_location); 

				}
				break;
			case 'save_changes_profile':
				$user= $_SESSION["user"];
				$name_surname = explode(" ", clean_variable($_REQUEST["update_name_surname"]));

				$info = ["name" => $name_surname[0], "surname" => $name_surname[1], "email" => $_REQUEST["update_email"]];
				

				if(sha1($_REQUEST["current_password"]) != $_SESSION["user_details"]["password"]){
				 	// error_notice("That is not your current password. Please try again.");
				 	update_personal_info($user, $info); 

				}
				elseif($_REQUEST["update_password-new"] != ''){
					if($_REQUEST["update_password-new"] != $_REQUEST["update_password-new_confirm"]){
						error_notice("The passwords you entered do not match. Please try again.");
					}
					else{
						$info["password"] = $_REQUEST["update_password-new"];
					}
				}
				else{
					update_personal_info($user, $info); 

				}
				$_SESSION["notices"] .= error_notice("", "get");
				
			break;
		case 'signup':
			$data = ["name" => $_POST["signup_name"], "surname" => $_POST["signup_surname"], "email" => $_POST["signup_email"], "password" => $_POST["signup_password"], "birth_date" => $_POST["signup_birth_date"], "credit_card_number" => $_POST["signup_credit_card_number"]];
			if($_POST["signup_password"] != $_POST["signup_confirm_password"]){
					error_notice("The passwords you entered do not match. Please try again.");
			}
			else{
				
				if(sign_up($data)){
					//header('Location: profile.php');
				}
			}
		break;
		case 'upload_pic':
			$_SESSION["temp_profile_picture"] = upload_picture_temp();
			finish_image_upload($_SESSION["temp_profile_picture"]); //eden pristap do baza
			unset($_SESSION["temp_profile_picture"]);

			break;
		


		}
	}
?>

<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({content: $(".data-toggle_link"), html:true});
    });
$(window).on( "load", function() {
    
    html_data = '';
     $.ajax({
                type: "POST",
                url: "get_notices_realtime.php",
                success: function(response){
                    html_data = response;
                   // alert(response);
                }
            });
    $("#notices").html(html_data);
});
</script>
