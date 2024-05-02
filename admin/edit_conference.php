<?php

// Set session variables with conference id and name
$conf_id = $_GET["id"];
$conf_name = $_GET["name"];
require_once "create_conference_view.php";
require_once "../includes/config.php";



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Conference Information</title>
    <link rel="stylesheet" href="create_conferences_styles.css">
    <link rel="stylesheet" href="../../bin/header_footer_styles.css">

</head>
<body>
    <?php include '../header.php'; ?>
    
    
    <div class="container">
        <h2>Edit Conference Information</h2>
        <?php 
        // Check if conference ID is set in the session

        if(isset($conf_id)) {
            require_once "../includes/dbh.inc.php";
            // Assuming you have already established a database connection
            // Query to retrieve conference information based on conference ID
            $query = "SELECT * FROM conferences WHERE conference_id = :conferenceId";
            $stmt = $pd0->prepare($query);
            $stmt->bindParam(":conferenceId", $conf_id);
            $stmt->execute();
            $conference = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if conference information is found
            if($conference) {
                // Populate the form fields with conference information
                ?>
                <form class="form" action="edit_conference_handler.php" method="post">
                    <div class="form-group">
                        <label for="conferenceName">Conference Name</label>
                        <input type="text" id="conferenceName" name="conferenceName" value="<?php echo $conference['conference_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location" value="<?php echo $conference['location']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="callForPapers">Call for Papers</label>
                        <select id="callForPapers" name="callForPapers" required>
                            <option value="1" <?php if($conference['call_for_papers'] == 1) echo 'selected'; ?>>Yes</option>
                            <option value="0" <?php if($conference['call_for_papers'] == 0) echo 'selected'; ?>>No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="conferenceDescription">Conference Description</label>
                        <textarea id="conferenceDescription" name="conferenceDescription" rows="5" required><?php echo $conference['conference_description']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="conferenceDate">Conference Date</label>
                        <input type="date" id="conferenceDate" name="conferenceDate" value="<?php echo $conference['conference_date']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="paperDueDate">Paper Due Date</label>
                        <input type="date" id="paperDueDate" name="paperDueDate" value="<?php echo $conference['paper_due_date']; ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Submit">
                    </div>
                    <?php display_message();?>
                </form>
                <?php
                $stmt =null;
            } else {
                // Conference not found, handle the case accordingly
                echo "Conference not found.";
            }
        } else {
            // Conference ID is not set in the session, handle the case accordingly
            echo "Conference ID not set.";
        }
        ?>
    </div>
    <?php include '../footer.php'?>
</body>
</html>

