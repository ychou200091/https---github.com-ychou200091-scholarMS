<?php
    # import session settings
    require_once "../includes/config.php";
    error_reporting(1);
    // Check if the user is logged in and if they are an admin
    if(isset($_SESSION["username"]) && strpos($_SESSION["username"], "admin-") === 0) {
        // User is logged in and is an admin, do nothing
    } else {
        // Redirect to the home page
        header("Location: /index.php");
        die(); // Make sure to exit after redirection
    }
    require_once "create_conference_view.php";
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
                <th>Edit</th>
                <th>Del</th>
                <th>Reg</th>
                <th>Paper</th>
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
            
            require_once "query_existing_conferences.php";

            foreach ($conferences as $conference) {
                echo "<tr>";
                echo "  <td>
                            <button onclick=\"window.location.href='edit_conference.php?id={$conference['conference_id']}&name={$conference['conference_name']}'\">Edit</button>
                        </td>
                        <td> 
                            <button onclick=\"window.location.href='delete_conference.php?id={$conference['conference_id']}&name={$conference['conference_name']}'\">Delete</button>
                        </td>
                        <td> 
                            <button onclick=\"window.location.href='see_c_attenders.php?id={$conference['conference_id']}&name={$conference['conference_name']}'\">See Attenders</button>
                        </td>

                        <td> 
                            <button onclick=\"window.location.href='view_paper_submissions.php?id={$conference['conference_id']}&name={$conference['conference_name']}'\">View Paper Submissions</button>
                        </td>
                        ";
                
                
                foreach ($conference as $value) {
                    echo "<td>$value</td>";
                }
                
                echo "</tr>";
            }
            echo '<br>';
            if(isset($_SESSION["conf_message"])){
                echo '<p>'.$_SESSION["conf_message"].'<\p>';
                unset($_SESSION["conf_message"]);
            }
            ?>
        </table>
        <?php display_message();?>
    </div></div>

    <?php include '../footer.php'?>
</body>
</html>
