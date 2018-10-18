<?php
	include "functions.php";
	get_company_details();
	$content = '<div class="container page_content">
				'. generate_log_form("signup") .'
				</div>';

	include "template.php";
?>
