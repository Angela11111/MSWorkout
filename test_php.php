<?php
include "functions.php";
get_company_details();
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
	    <div class="navbar-header main_menu-header">
	      <a class="navbar-brand main_menu-header--company" href="#">acme</a>
	    </div>
	    <ul class="nav navbar-nav navbar-right main_menu-login">
	      <li><a href="#" class="main_menu-link">Log in<div class="glyphicon glyphicon-user login-glyphicon"></div></a></li>
	    </ul>
	  </div>
	</nav>  

	<main>
		<div class="site_content">
			<section id="myCarousel" class="carousel slide section_default" data-ride="carousel">
			    <div class="carousel_contents container">
			    	<!-- Indicators -->
				    <ol class="carousel-indicators">
				      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				      <li data-target="#myCarousel" data-slide-to="1"></li>
				      <li data-target="#myCarousel" data-slide-to="2"></li>
				    </ol>

				    <!-- Wrapper for slides -->
				    <div class="carousel-inner row">

				      <?php 
				      	print(generate_carousel_items());
				      ?>

				    <!-- Left and right controls -->
				    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
				      <span class="glyphicon glyphicon-circle-arrow-left carousel-btn_prev"></span>
				      <span class="sr-only">Previous</span>
				    </a>
				    <a class="right carousel-control" href="#myCarousel" data-slide="next">
				      <span class="glyphicon glyphicon-circle-arrow-right carousel-btn_next"></span>
				      <span class="sr-only">Next</span>
				    </a>
			    	
			    </div>
			</section>

			<section class="section_alt featured_programs">

				<div class="featured_programs_content container">
					<div class="featured_programs_content-title">
						<h2>
							Programs
						</h2>
					</div>


					<div class="container-fluid featured_programs_content-list">
						<?php 
							print(generate_all_programs());
						?>
					</div>
				</div>
			</section>

			<section class="about_us">
				<div class="container about_us-content container">
					<div class="about_us-content--title">
						<h2>About Us</h2>
					</div>
					<p class="about_us-content--text">
						<?php
							print(get_page_content("About-mandatory")); 
						?>
					</p>
					<p class="about_us-content--text paragraph_optional">
						<?php
							print(get_page_content("About-optional")); 
						?>
					</p>
				</div>
			</section>

			<section class="contact section_alt">
				<div class="container contact_content">
					<div class="contact_content--title">
						<h2>Contact</h2>
					</div>

					<div id="map" class="imgg col-sm-12"></div>

					<div class="contact_info row">
						<button class="btn btn-lg contact_info-btn">
							<span class="glyphicon glyphicon-map-marker contact_info-glyphicon"></span>
							<?php
								print($_SESSION["company"]["adress"]);
							?>
						</button>
						<button class="btn btn-lg contact_info-btn">
							<span class="glyphicon glyphicon-phone contact_info-glyphicon"></span>
							<?php
								print($_SESSION["company"]["phone"]);
							?>
						</button>
					</div>

					<div>
						<form action="/action_page.php" class="col-sm-4 col-sm-offset-4 contact_message_form">

						  <div class="form-group">
						    <label for="email" hidden="true">Email address:</label>
						    <input type="email" class="form-control" id="email" placeholder="Email adress">
						  </div>

						  <div class="form-group">
						    <label for="pwd" hidden="true">Password:</label>
						    <input type="password" class="form-control" id="pwd" placeholder="Password">
						  </div>

						  <div class="form-group">
						    <label for="message" hidden="true">Message:</label>
						    <textarea class="form-control" id="message" placeholder="Type your message"></textarea>
						  </div>

						  <button type="submit" class="btn contact_message_form-btn_send">Send a message</button>

						</form>
					</div>
				</div>
			</section>
		</div>
	</main>

	<footer class="site_footer container-fluid">
		<div class="container">
			<div class="site_footer-left pull-left">
				<h3 class="site_footer-left--company">ACME</h3>
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

<script>
function myMap() {
var mapOptions = {
    center: new google.maps.LatLng(51.5, -0.12),
    zoom: 10,
    mapTypeId: google.maps.MapTypeId.HYBRID
}
var map = new google.maps.Map(document.getElementById("map"), mapOptions);
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=0ahUKEwjA3ZLmzMvdAhXowIsKHRN1CasQ_AUIDigB&callback=myMap"></script>
</body>
</html>