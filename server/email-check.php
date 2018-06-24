<?php

define("EMAIL_NOT_UNIQUE", 20);

if(isset($_POST["email"])){
	$email = $_POST["email"];

	require_once "SignUpUtility.php";
	$signup = new SignUp();

	if(!$signup->emailUnique($email)){
		$response["error"] = true;
		$response["error_number"] = EMAIL_NOT_UNIQUE;
		$response["error_message"] = "$email not unique";
	} else {
		$response["error"] = false;
	}
	echo json_encode($response);
}


?>