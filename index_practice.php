<?php
    require_once "includes/config.php";
    require_once "includes/signup_view.inc.php";
    require_once "includes/login_view.inc.php";

    error_reporting(1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholar Management System - Sign Up</title>
    <link rel="stylesheet" href="bin/styles.css"> 
</head>
<body>
    <h3><?php show_login_user(); ?></h3>
    
    <div>
        <form action="includes/signuphandler.inc.php" method="POST">
            <h1>Scholar Management System</h1>
            <h2>Sign Up</h2>
            <?php signup_inputs()?>
            <?php check_signup_errors();?>
        </form>

        
        
    </div>
    <div>
        <form action="includes/loginhandler.inc.php" method="POST">
            <h1>Scholar Management System</h1>
            <h2>Login</h2>
            <input type="text" name="username" placeholder="Username" >
            <input type="password" name="password" placeholder="Password" >
            <input type="Submit" value="Login">
            <?php check_login_errors(); ?>
        </form>
    </div>
    <div>
        <form action="includes/logout.inc.php" method="POST">
            <h2>Logout</h2>
            <button>Logout</button>
        </form>
    </div>

    <link rel="stylesheet" href="bin/header_footer_styles.css">
    <?php include 'header.php'; ?>
    <?php include 'footer.php'?>
</body>
</html>

