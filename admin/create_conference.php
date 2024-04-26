<?php
// Redirect to create_conference page

require_once "../includes/config.php";
require_once "create_conference_view.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Conference Information</title>
    <link rel="stylesheet" href="create_conferences_styles.css">
    <link rel="stylesheet" href="../bin/header_footer_styles.css">

</head>
<body>
    <?php include '../header.php'; ?>
    
    
    <div class="container">
        <h2>Input New Conference Information</h2>
        <form class="form" action="create_conference_handler.php" method="post">
            <div class="form-group">
                <label for="conferenceName">Conference Name</label>
                <input type="text" id="conferenceName" name="conferenceName" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" required>
            </div>
            <div class="form-group">
                <label for="callForPapers">Call for Papers</label>
                <select id="callForPapers" name="callForPapers" required>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
            <div class="form-group">
                <label for="conferenceDescription">Conference Description</label>
                <textarea id="conferenceDescription" name="conferenceDescription" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="conferenceDate">Conference Date</label>
                <input type="date" id="conferenceDate" name="conferenceDate" required>
            </div>
            <div class="form-group">
                <label for="paperDueDate">Paper Due Date</label>
                <input type="date" id="paperDueDate" name="paperDueDate" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
            <?php display_message();?>
        </form>
    </div>
    <?php include '../footer.php'?>
</body>
</html>

