<?php
// Assuming you have already established a database connection
require_once "../includes/config.php";

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

function go_prev_page() {
    if (isset($_SERVER["HTTP_REFERER"])) {
        $referer = $_SERVER["HTTP_REFERER"];
        echo "HTTP Referer: $referer"; // Debugging statement
        header("Location: $referer");
        exit; // Stop script execution after redirection
    } else {
        echo "<p> HTTP Referer is not set.</p>"; // Debugging statement
    }
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
    <div class="attendees table">
        <button onclick="goBack()">Go Back</button>
        <script>
            function goBack() {
                window.location.href = document.referrer;
            }
        </script>
        <h1>Attendies for <?php echo $conf_name; ?></h1>
        <table class = "table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Meal Preference</th>
                    <th>Representative Unit</th>
                    <th>Registration Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($attendees as $attendee): ?>
                    <tr>
                        <td><?php echo $attendee['first_name'] . ' ' . $attendee['last_name']; ?></td>
                        <td><?php echo $attendee['email']; ?></td>
                        <td><?php echo $attendee['phone_number']; ?></td>
                        <td><?php echo $attendee['meal_preference']; ?></td>
                        <td><?php echo $attendee['representative_unit']; ?></td>
                        <td><?php echo $attendee['registration_date']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
       
    </div>
    <?php display_message();?>

    
    <?php include '../footer.php'?>
</body>
</html>
