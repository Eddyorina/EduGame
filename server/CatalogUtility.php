<?php

class CatalogUtility {

    private $conn;

    function __construct() {
        require_once("connection.php");
        $this->conn = (new Connection())->getConnection();
    }

    function getNewGames() {
        $sql = "SELECT * FROM games WHERE publish_date > DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH);";
        if ($query = $this->conn->prepare($sql)){
            if($query->execute()){
                $response["error"] = false;
                $response["games"] = $query->get_result()->fetch_assoc();
                echo json_encode($response);
            } else {
                $response["error"] = true;
                $response["error_message"] = $query->error;
                echo json_encode($response);
            }
        } else {
            $response["error"] = true;
            $response["error_message"] = $this->conn->error;
        }
    }
    
}

if(isset($_POST["new_games"])){
    $catalog_util = new CatalogUtility();
    $catalog_util->getNewGames();
}

?>