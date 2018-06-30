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

                $result = $query->get_result();
                $row = array();
                while($r = $result->fetch_assoc()){
                    $row[] = $r;
                }
                $response["games"] = $row;
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
    
    function get_games_as_per_subject(){
        $sql = "SELECT * FROM games ORDER BY subject;";
        $games;
        if($query = $this->conn->prepare($sql)){
            if($query->execute()){
                $result_set = $query->get_result();
                while($row = $result_set->fetch_assoc()){
                    $games[$row["subject"]][] = $row;
                }
                $response["error"] = false;
                $response["games"] = $games;
            } else {
                $response["error"] = true;
                $response["error_message"] = $query->error;
            }
        } else {
            $response["error"] = true;
            $response["error_message"] = "Preparation error!";
        }
        echo json_encode($response);
    }
}

$catalog_util = new CatalogUtility();

if(isset($_POST["new_games"])){
    $catalog_util->getNewGames();
} elseif(isset($_POST["games"])){
    $catalog_util->get_games_as_per_subject();
}
?>