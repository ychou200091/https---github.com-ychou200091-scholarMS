<?php
    # import session settings
    require_once "../includes/config.php";
    error_reporting(1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScholarMS-Admin Interface</title>
    <link rel="stylesheet" href="aindex.css">
    <link rel="stylesheet" href="../bin/header_footer_styles.css">
    

</head>
<body>
    <?php include '../header.php'; ?>
    <h1>ScholarMS-Admin Interface</h1>
    <h2>Conference Information</h2>
    <div class="container">
    <div class="main">
        <button onclick="window.location.href='create_conference.php'">Create a Conference</button>
        <table class="display_conferences">
            <tr>
                <th>Actions</th>
                <th>ID</th>
                <th>Conference Name</th>
                <th>Location</th>
                <th>Call for Papers</th>
                <th>Description</th>
                <th>Date</th>
                <th>Paper Due Date</th>
                
            </tr>
            <?php
            // Fetch conferences from the database and display them in rows
            // Replace this with your database query
            $conferences = array(
                array("1", "Conference 1", "Location 1", "Call for Papers 1", "Description 1", "Date 1", "Due Date 1"),
                array("2", "Conference 2", "Location 2", "Call for Papers 2", "Description 2", "Date 2", "Due Date 2"),
                // Add more conferences as needed
            );

            foreach ($conferences as $conference) {
                echo "<tr>";
                echo "<td>
                        <button onclick=\"window.location.href='edit_conference.php?id={$conference[0]}&name={$conference[1]}'\">Edit</button>
                        <button onclick=\"window.location.href='delete_conference.php?id={$conference[0]}'\">Delete</button>
                        <button onclick=\"window.location.href='see_c_attenders.php?id={$conference[0]}&name={$conference[1]}'\">See Attenders</button>
                        <button onclick=\"window.location.href='view_paper_submissions.php?id={$conference[0]}&name={$conference[1]}'\">View Paper Submissions</button>
                        </td>";
                
                
                foreach ($conference as $value) {
                    echo "<td>$value</td>";
                }
                
                echo "</tr>";
            }
            ?>
        </table>
    </div></div>

    <?php include '../footer.php'?>
</body>
</html>
