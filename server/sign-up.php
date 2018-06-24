<?php

require_once "SignUpUtility.php";

if(isset($_POST["firstname"]) && 
	isset($_POST["lastname"]) &&
	isset($_POST["email"]) &&
	isset($_POST["password"]))
{
	$signup = new SignUP();
	$signup->emailUnique($_POST["email"]);
} else {
	//replace below code
	$response["error"] = true;
	$response["error_message"] = "parameter not set";
	echo json_encode($response);
}

?>