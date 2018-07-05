<?php

class AdminUtility {
    private $connection;

	function __construct() {
		require_once "connection.php";
		$this->connection = (new Connection())->getConnection();
	}

    function addGame($name, $description, $link, $subject, $thumbnail){
        $sql = "INSERT INTO games (name, description, link, subject, thumbnail) VALUES (?,?,?,?,?)";
        if($query = $this->connection->prepare($sql)){
            $query->bind_param("sssss", $name, $description, $link, $subject, $thumbnail);
            if($query->execute()){
                $response["error"] = false;
            } else {
                $response["error"] = true;
                $response["error_message"] = $query->error;
            }
        } else {
            $response["error"] = true;
            $response["error_message"] = $this->connection->error;
        }
        echo json_encode($response);
    }

    function deleteGame($game_id){
        $sql = "DELETE FROM games WHERE game_id=?";
        $response;
        if($query = $this->connection->prepare($sql)){
            $query->bind_param("i", $game_id);
            if($query->execute()){
                $response["error"] = false;
            } else {
                $response["error"] = false;
                $response["error_message"] = $query->error;
            }
        } else {
            $response["error"] = true;
            $response["error_message"] = $this->connection->error;
        }
        echo json_encode($response);
    }
    
}

if(isset($_POST["deleteGame"])){
    $admin = new AdminUtility();
    $admin->deleteGame($_POST["deleteGame"]);

}elseif(isset($_FILES["thumbnail"]) &&
    isset($_FILES["gameFile"]) &&
    isset($_POST["game-description"]) &&
    isset($_POST["game-name"]) &&
    isset($_POST["subject"]))
{
    $target_file_image = "C:/xampp/htdocs/finalproject/edugame/Upload-test/" . basename($_FILES["thumbnail"]["name"]);
    $target_file_game = "C:/xampp/htdocs/finalproject/edugame/" . basename($_FILES["gameFile"]["name"]);
    if(!move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file_image) && 
        !move_uploaded_file($_FILES["gameFile"]["tmp_name"], $target_file_game))
    {
        $response["error"] = true;
        $response["error_message"] = "Issue uploading image.";
        echo json_encode($response);
    } else {
        $admin = new AdminUtility();
        $admin->addGame(
            $_POST["game-name"],
            $_POST["game-description"],
            basename($_FILES["gameFile"]["name"]),
            $_POST["subject"],
            "upload-test/".basename($_FILES["thumbnail"]["name"])
        );
    }
} else {
    $response["error"] = true;
    $response["error_message"] = "Parameter not set";
    echo json_encode($response);
}

?>