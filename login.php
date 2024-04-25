<?php
    # import session settings
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
    <link rel="stylesheet" href="bin/login_styles.css">
    <link rel="stylesheet" href="bin/header_footer_styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="login-container">
        <h2>Login</h2>
        <form action="includes/loginhandler.inc.php" method="POST">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" >
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" >
            </div>
            <button type="submit">Login</button>
            <?php check_login_errors(); ?>
        </form>
    </div>
    <?php include 'footer.php'?>
</body>
</html>
