<?php

class Login {

	private $connect;

	function __construct() {
		require_once "connection.php";
		$register = new Connection();
		$this->connect = $register->getConnection();
	}

	public function checkCredentials($email, $password){
		$query = $this->connect->prepare("SELECT password FROM users WHERE email = ?");
		$query->bind_param("s", $email);
		if($query->execute()) {
			$result = $query->get_result();
			$num_of_rows = $result->num_rows;
			if($num_of_rows > 0){
				$user = $result->fetch_assoc();
				if($user["password"] === $password){
					$response["error"] = false;
				} else {
					$response["error"] = true;
					$response["error_message"] = "Incorrect password";
				}
				echo json_encode($response);
			} else {
				$response["error"] = true;
				$response["error_message"] = "Account does not exist";
				echo json_encode($response);
			}
		} else {
			echo "This is bad";
		}
	}

	private function grantAccess($firstname){
		echo "<h1>Welcome $firstname<h1>";
	}

}


if(isset($_POST["email"]) && isset($_POST["password"])){
	$username = $_POST["email"];
	$password = $_POST["password"];
	$login = new Login();

	$login->checkCredentials($username, $password);
} else {
	$response["error"] = true;
	$response["error_message"] = "Parameters not set";
	echo json_encode($response);
}

?>