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
    <title>ScholarMS - Conference Management System</title>
    <link rel="stylesheet" href="/bin/homepage_styles.css">
    <link rel="stylesheet" href="/bin/header_footer_styles.css">


</head>
<body>
    <?php include 'header.php'; ?>

    <section id="hero">
        <div class="hero-content">
            <h1>Join the top conferences in the world</h1>
            <p>Submit paper or Attend your dream conference today!</p>
        </div>
    </section>

    <section id="body">
        <h2 class="body-title">Search for Conference</h2>
        <p class="subtitle">1. Search for all conference information and related paper now</p>
        <p class="subtitle">2. Apply to attend the conference</p>
        <p class="subtitle">3. Submit your paper</p>
        <a href="/conference_lookup/conference_lookup.php" class="search-btn">SEARCH FOR CONFERENCE</a>
    </section>
    <?php include 'footer.php'?>
    
</body>
</html>
