<?php
$database_host = "localhost";
$database_user = "root";
$database_password = "root";
$database_name = "workout_ms";

global $database_connection;
$database_connection = mysqli_connect($database_host, $database_user, $database_password, $database_name);

if(!$database_connection){
	print("We couldn't connect to the database due to" . mysqli_connect_errno() . PHP_EOL);
}


?>