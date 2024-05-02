<?php
    # import session settings
    header("Location: {$_SERVER['HTTP_REFERER']}");
    require_once "includes/config.php";
    
    require_once "includes/login_view.inc.php";

    error_reporting(1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScholarMS-Login</title>
    <link rel="stylesheet" href="bin/basic_styles.css">
    <link rel="stylesheet" href="bin/header_footer_styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <?php include 'footer.php'?>
</body>
</html>
