<?php
function get_featured_programs(){
	if(!isset($_SESSION["programs"])){
		get_programs();
	}

	$featured = [];
	foreach ($_SESSION["programs"] as $program) {
		if($program["featured"] == '1') {
			$featured[$program["id"]] = $program;
		}
	}

	return $featured;
}

function generate_carousel_items(){
	$output = '';

	$featured_programs = get_featured_programs();

	//var_dump($_SESSION["programs"]);
	$first = "active";
	foreach($featured_programs as $featured_program) {
		$programs_locations ='';
		if(isset($_SESSION["user"])){
			$programs_locations = get_program_location_id($featured_program["id"] , $_SESSION["user"]);
		}
											$output .= '<div class="item '. $first .'" id="carousel_program_'. $featured_program["id"] .'">
									<a href="program_details.php?action=program_details&program_id='. $featured_program["id"] .'&program_in_location_id='. $programs_locations  .'">
								      	<div class="col-sm-6 carousel_item_content">
								          
								          	<h3 class="carousel_item_content-title">'. $featured_program["name"] .'</h3>
								          
								          <p  class="carousel_item_content-text">'. $featured_program["description"].'</p>
								        </div>
							        
							        	<img src="'. $featured_program["program_image"] .'" alt="Los Angeles" class="col-sm-6 carousel-img">
							     	</a>
							     </div>';
						$first = "";
					
		
	}
	return $output;
}

function generate_all_programs(){
	if(!isset($_SESSION["programs"])){
		get_programs();
	}
	$output = '';
	foreach ($_SESSION["programs"] as $program) {
		$programs_locations ='';
		if(isset($_SESSION["user"])){
			$programs_locations = get_program_location_id($program["id"] , $_SESSION["user"]);
		}
		$output .= '<div class="featured_programs_content-list--program col-sm-4" id="'.$program["id"].'">

							<img src="'. $program["program_image"] .'" alt="Los Angeles" style="width:100%;">

							<div class="featured_programs_content-list--program-description"> 
								<h3>'. $program["name"] .'</h3>
								'. substr($program["description"], 0, 100) .'..
								<a href="program_details.php?action=program_details&program_id='. $program["id"] .'&program_in_location_id='.$programs_locations  .'" class="btn featured_programs_content-list--program-description--btn_signup"> See </a>
							</div>
						</div>'; //<a> beshe button
	}
	return $output;
}
?>