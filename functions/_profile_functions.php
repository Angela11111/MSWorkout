<?php
function get_user_programs($user =''){
	global $database_connection;
	
	if($user == ''){
		if(!isset($_SESSION["user_in_programs"])){
			
			$query = "SELECT count(mem.id) as number_of_members_in_program, mem.program_in_location as program_in_location, q.program_name as name, q.user_date as user_joined_date, q.program_id as id, q.full_adress as location from members mem, (select m.program_in_location as program_in_location, p.id as program_id, p.name as program_name, m.date_entered as user_date, l.full_adress from members m, programs p, programs_locations pl, locations l where m.user_id = ". $_SESSION["user"] . " and m.program_in_location = pl.id and pl.program_id = p.id and l.id = pl.location_id)q where mem.program_in_location = q.program_in_location group by q.program_name, q.user_date, q.program_id, q.full_adress, mem.program_in_location;";
			$programs = mysqli_query($database_connection, $query);

			//var_dump($programs);
			while ($program = mysqli_fetch_array($programs)) {
				 
				$_SESSION["user_in_programs"][$program["id"]] = $program;
										  //[$program["id"]]
			}
		}
		return 0;
	}
	else{
		$query = "SELECT count(mem.id) as number_of_members_in_program, mem.program_in_location as program_in_location, q.program_name as name, q.user_date as user_joined_date, q.program_id as id, q.full_adress as location from members mem, (select m.program_in_location as program_in_location, p.id as program_id, p.name as program_name, m.date_entered as user_date, l.full_adress from members m, programs p, programs_locations pl, locations l where m.user_id = ". $_SESSION["user"] . " and m.program_in_location = pl.id and pl.program_id = p.id and l.id = pl.location_id)q where mem.program_in_location = q.program_in_location group by q.program_name, q.user_date, q.program_id, q.full_adress, mem.program_in_location;";
			$programs = mysqli_query($database_connection, $query);

			//var_dump($programs);
			while ($program = mysqli_fetch_array($programs)) {
				 
				$user_programs[$program["id"]] = $program;
										  //[$program["id"]]
			}

			return $user_programs;
	}

	//return $_SESSION["user_in_programs"];
}

//print_r(get_user_programs());
function generate_user_programs_items($user=''){
	global $database_connection;

	$output ='';
	if(!isset($_SESSION["user_in_programs"])){
		get_user_programs($user);
	}

	$user_programs =  $_SESSION["user_in_programs"];
	

	foreach ($user_programs as $program) {
		$output .= '<a href="program_details.php?program_id='. $program["id"] . '&program_in_location_id='.$program["program_in_location"] .'" class="user_programs-content--program" id="'. $program["id"] . '">
				   		<span class="user_programs-content--program-name">
				   			' . $program["name"] . '
				   		</span>
				   		<div class="user_programs-content--program-details">
				   			<span class="user_programs-content--program-details--item">
				   				' . $program["number_of_members_in_program"] . ' participants
					   		</span>
					   		<span class="user_programs-content--program-details--item">
					   			' . $program["location"] . '
					   		</span>
					   		<span class="user_programs-content--program-details--item">
					   			signed up on ' . $program["user_joined_date"] . '
					   		</span>
				   		</div>
				   </a>';
	}

	return $output;
}

?>