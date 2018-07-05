<?php

class AdminUtility {
    private $connection;

	function __construct() {
		require_once "connection.php";
		$this->connection = (new Connection())->getConnection();
	}

    function addGame($name, $description, $subject, $thumbnail){
        
    }
    
}

if(isset($_FILES["thumbnail"])){
    $response["error"] = false;
    echo json_encode($response);
} else {
    $response["error"] = true;
    $response["error_message"] = "File not sent";
    echo json_encode($response);
}

?>