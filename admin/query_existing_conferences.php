<?php
try{
    require_once("../includes/dbh.inc.php");
    $query = "SELECT * FROM conferences";
    
    // Prepare and execute the statement
    $stmt = $pd0->query($query);
    
    // Fetch all conferences as an associative array
    $conferences = $stmt->fetchAll(PDO::FETCH_ASSOC);

}catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $_SESSION["conf_message"] = $e->getMessage();
    header("Location: {$_SERVER['HTTP_REFERER']}");
}


?>