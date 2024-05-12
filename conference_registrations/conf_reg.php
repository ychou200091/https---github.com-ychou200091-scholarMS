<?php
require_once "../display_user_msg.php";
require_once "../includes/dbh.inc.php";
require_once "../includes/config.php";
// Check if conference ID and name are provided
if (!isset($_SESSION["user_id"])) {
    $_SESSION["user_message"] = "*Please login first*";
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}
// Check if the user is logged in and if they are an admin
if(isset($_SESSION["username"]) && strpos($_SESSION["username"], "admin-") === 0) {
    $_SESSION["user_message"] = "*Please use an user account*";
    header("Location: {$_SERVER['HTTP_REFERER']}");
    die();
} 
if(isset($_GET["id"]) && isset($_GET["name"])) {
    // Sanitize input
    $conf_id = $_GET["id"];
    $conf_name = $_GET["name"];

    // Query database to find conference date
    $query = "SELECT conference_date FROM conferences WHERE conference_id = :conf_id";
    $stmt = $pd0->prepare($query);
    $stmt->bindParam(":conf_id", $conf_id);
    $stmt->execute();
    $conference = $stmt->fetch(PDO::FETCH_ASSOC);
    $conf_date = $conference['conference_date'];
} else {
    // Conference ID or name not provided, handle the error accordingly
    $_SESSION["user_message"] = "Conference ID or name not provided.";
    header("Location:  {$_SERVER['HTTP_REFERER']}");
    exit;
}

$_SESSION["conf_id"]=$conf_id;
$_SESSION["conf_name"]=$conf_name;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conference Registration</title>
    <link rel="stylesheet" href="../bin/header_footer_styles.css">
    <link rel="stylesheet" href="conf_reg_styles.css"> <!-- Include your CSS file for styling -->
</head>
<body>
    <?php include '../header.php'; ?>
    <div class="container">
        <h1>Conference Registration for <?php echo $conf_name; ?></h1>
        
        <p>Conference Date: <?php echo $conf_date; ?></p>

        <form action="conf_reg_handler.php" method="post">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" required>
            </div>
            <div class="form-group">
                <label for="meal_preference">Meal Preference</label>
                <select id="meal_preference" name="meal_preference" required>
                    <option value="regular">regular</option>
                    <option value="vegan">vegan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="representative_unit">Representative Unit</label>
                <input type="text" id="representative_unit" name="representative_unit" required>
            </div>
            
            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
        </form>
        <?display_message()?>
    </div>
    <?php include '../footer.php'?>
</body>
</html>
