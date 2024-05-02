<?php
// Assuming you have already established a database connection
require_once "../includes/dbh.inc.php";

try {
    // Check if conference ID and name are provided
    if(isset($_GET["id"]) && isset($_GET["name"])) {
        // Sanitize input
        $conf_id = $_GET["id"];
        $conf_name = $_GET["name"];

        // Construct the delete query
        $query = "DELETE FROM conferences WHERE conference_id = :conf_id AND conference_name = :conf_name";
        $stmt = $pd0->prepare($query);
        $stmt->bindParam(":conf_id", $conf_id);
        $stmt->bindParam(":conf_name", $conf_name);

        // Execute the delete query
        if ($stmt->execute()) {
            // Delete successful
        } else {
            // Delete failed, handle the error accordingly
            $_SESSION["conf_message"] = $e->getMessage();
            echo "Failed to delete the conference. Please try again.";
        }
        // redirect back to the previous page
        $stmt = null;
        
    } else {
        // Conference ID or name not provided, handle the error accordingly
        echo "Conference ID or name not provided.";
        $_SESSION["conf_message"] = "Conference ID or name not provided.";
    }
    header("Location: {$_SERVER['HTTP_REFERER']}");
    die();
} catch (PDOException $e) {
    // PDO error occurred, handle it
    echo "Error: " . $e->getMessage();
    $_SESSION["conf_message"] = $e->getMessage();
    header("Location: {$_SERVER['HTTP_REFERER']}");
    die();
}
?>
