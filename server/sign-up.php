<?php

require_once "SignUpUtility.php";

if(isset($_POST["firstname"]) && 
	isset($_POST["lastname"]) &&
	isset($_POST["_email"]) &&
	isset($_POST["password"]))
{
	$signup = new SignUP();
	$signup->register($_POST["_email"], $_POST["firstname"], $_POST["lastname"], $_POST["password"]);
} else {
	$response["error"] = true;
	$response["error_message"] = "parameter not set";
	echo json_encode($response);
}

?>