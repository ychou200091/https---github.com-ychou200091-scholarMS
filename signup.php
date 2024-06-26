
<?php
    require_once "includes/config.php";
    require_once "includes/signup_view.inc.php";

    error_reporting(1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholar Management System - Sign Up</title>
    <link rel="stylesheet" href="bin/signup_styles.css"> 
    <link rel="stylesheet" href="bin/header_footer_styles.css">
    
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div>
        <form class="signup-form" action="includes/signuphandler.inc.php" method="POST">
            <h1>Scholar Management System</h1>
            <h2>Sign Up</h2>
            <?php signup_inputs()?>
            <?php check_signup_errors();?>
        </form>
       
    </div>
        
    
    <?php include 'footer.php'?>
</body>
</html>

