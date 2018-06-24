<?php

class SignUp {
	private $connection;

	function __construct() {
		require_once "connection.php";
		$this->connection = (new Connection())->getConnection();
	}

	/* function register($firstname, $lastname, $email, $password){
		$hashed_password = password_hash($password);

		if (emailUnique($email)){
			$query = $this->connection->prepare(
				"INSERT INTO users "
			);
		} else {
			$response["error"] = true;
			// $response["error"] = ""
		}

	} */

	function register($email, $firstname, $lastname, $password){
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);

		$sql = "INSERT INTO users(email, firstname, lastname, password) VALUES(?,?,?,?)";
		
		if($query = $this->connection->prepare($sql)){
			$query->bind_param("ssss", $email, $firstname, $lastname, $hashed_password);
			if($query->execute()){
				$response["error"] = false;
				echo json_encode($response);
			} else {
				$response["error"] = true;
				$response["error_message"] = "Execution issues";
				echo json_encode($response);
			}
		} else {
			$response["error"] = true;
			$response["error_message"] = "Querying issues";
			echo json_encode($response);
		}
			
		
	}

	public function emailUnique($email){
		$query = $this->connection->stmt_init();
		if($query->prepare("SELECT COUNT(email) AS count FROM users WHERE email = ?")){
			$query->bind_param("s", $email);
			$query->execute();
			$result = $query->get_result()->fetch_assoc();
			return $result["count"] > 0 ? false : true;
		} else {
			$response["error"] = true;
			$response["error_message"] = "Unable to query database.";
			echo json_encode($response);
		}
	}

}





?>