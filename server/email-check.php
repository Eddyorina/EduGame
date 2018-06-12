<?php

if(isset($_POST["email"])){
	$email = $_POST["email"];

	require_once "SignUp.php";
	$signup = new SignUp();

	if(!$signup->emailUnique($email)){
		$response["error"] = true;
		$response["error_message"] = "$email not unique";
	} else {
		$response["error"] = false;
	}
	echo json_encode($response);
}


?>