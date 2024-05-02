<?php
// Assuming you have already established a database connection
require_once "../includes/config.php";
require_once "../includes/login_view.inc.php";
error_reporting(1);
require_once 'display_admin_msg.php';
try {
    require_once("../includes/dbh.inc.php");
    // Check if conference ID and name are provided
    if(isset($_GET["id"]) && isset($_GET["name"])) {
        // Sanitize input
        $conf_id = $_GET["id"];
        $conf_name = $_GET["name"];

        // Query database to find attendees for the selected conference
        $query = "SELECT * FROM registrations WHERE conference_id = :conf_id;";
        $stmt = $pd0->prepare($query);
        $stmt->bindParam(":conf_id", $conf_id);
        
        $stmt->execute();
        $attendees = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } else {
        // Conference ID or name not provided, handle the error accordingly
        $_SESSION["conf_message"] = "Conference ID or name not provided.";
        
    }
} catch (PDOException $e) {
    // PDO exception occurred, handle it
    echo "Error: " . $e->getMessage();
    $_SESSION["conf_message"] = $e->getMessage();
    
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendees</title>
    <link rel="stylesheet" href="see_c_attenders.css">
    <link rel="stylesheet" href="../bin/header_footer_styles.css">
</head>
<body>
    <?php include '../header.php'; ?>
    
    
    <div class="attendies">
        <h1>Attendees for <?php echo $conf_name; ?></h1>
        <ul>
            <?php foreach($attendees as $attendee): ?>
                <li><?php echo $attendee['name']; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php display_message();?>
    <?php include '../footer.php'?>
</body>
</html>
