<?php
session_start();
// Set session variables with conference id and name
$_SESSION["conference_id"] = $_GET["id"];
$_SESSION["conference_name"] = $_GET["name"];
// Redirect to edit_conference page

header("Location: {$_SERVER['HTTP_REFERER']}");
exit;
?>
