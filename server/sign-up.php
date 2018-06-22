<?php

require_once "SignUp.php";

if(isset($_POST["firstname"]) && 
	isset($_POST["lastname"]) &&
	isset($_POST["email"]) &&
	isset($_POST["password"]))
{
	$signup = new SignUP();
	$signup->emailUnique($_POST["email"]);
} else {
	//replace below code
	echo "parameter not set";
}

?>