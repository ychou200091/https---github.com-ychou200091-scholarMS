<?php
error_reporting(1);
require_once "../includes/dbh.inc.php";
require_once "../includes/config.php";
require_once "../display_user_msg.php";
require_once "conf_help_functions.php";
$conf_id = $_GET["id"];
$conf_name = $_GET["name"];
// Check if user is signed in
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

// Check if conference accepts paper submissions

if(!isset($_GET["id"])){
    $_SESSION["user_message"] = '$_GET["id"] not set';
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

if (!can_conf_submit_paper($conf_id)) {
    $_SESSION["user_message"] = $conference.".".$paper_due_date.".". $current_date."*This conference does not accept new paper submission*";
    header("Location: {$_SERVER['HTTP_REFERER']}");
}

// Store conference ID and name in session
$_SESSION["conference_id"] = $_GET["id"];
$_SESSION["conference_name"] = $_GET["name"];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Paper</title>
    <link rel="stylesheet" href="../bin/header_footer_styles.css">
    <link rel="stylesheet" href="submit_new_paper.css"> <!-- Link to external CSS file -->
</head>
<body>
    <?php include '../header.php'; ?>
    <div class="container">
    <h1>Submit Paper for <?php echo $_SESSION["conference_name"] ; ?></h1>
    
        <form action="submit_new_paper_handler.php" method="POST" enctype="multipart/form-data">
            <?php display_message()?>    
            <label for="authors">Authors:</label>
            <input type="text" id="authors" name="authors" required><br>

            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required><br>

            <label for="keywords">Keywords:</label>
            <input type="text" id="keywords" name="keywords" required><br>

            <label for="abstract">Abstract:</label>
            <textarea id="abstract" name="abstract" rows="4" required></textarea><br>

            <label for="additional_comment">Additional Comment:</label>
            <textarea id="additional_comment" name="additional_comment" rows="4"></textarea><br>

            <label for="file">Upload PDF:</label>
            <input type="file" id="file" name="paper_upload" accept=".pdf" required><br>

            <input type="submit" value="Submit Paper">
        </form>
    </div>
    <?php include '../footer.php'?>
</body>
</html>