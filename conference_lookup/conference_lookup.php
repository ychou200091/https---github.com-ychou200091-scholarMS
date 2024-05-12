<?php
    # import session settings
    error_reporting(1);
    require_once "../includes/config.php";
    require_once "../display_user_msg.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScholarMS-Conference Lookup</title>
    <link rel="stylesheet" href="conference_lookup.css">
    <link rel="stylesheet" href="../bin/header_footer_styles.css">
    

</head>
<body>
    <?php include '../header.php'; ?>
    <h1>ScholarMS-Conference Lookup</h1>
    <h2>Conference Information</h2>
    <div class="container">
    
    <div class="main">
      <?php display_message();?>
        <table class="display_conferences">
            <tr>
                <th>Lookup Paper</th>
                <th>Submit Paper</th>
                <th>Reg</th>
                <th>ID</th>
                <th>Conference Name</th>
                <th>Location</th>
                <th>Call for Papers</th>
                <th class="description-column">Description</th>
                
                <th>Date</th>
                <th>Paper Due Date</th>
                
            </tr> 
            <?php
            // Fetch conferences from the database and display them in rows
            // Replace this with your database query
            
            require_once "../admin/query_existing_conferences.php";

            foreach ($conferences as $conference) {
                echo "<tr>";
                echo "  <td>
                            <button onclick=\"window.location.href='lookup_conf_paper.php?id={$conference['conference_id']}&name={$conference['conference_name']}'\">Lookup Paper</button>
                        </td>";
                echo "  <td>
                            <button onclick=\"window.location.href='submit_new_paper.php?id={$conference['conference_id']}&name={$conference['conference_name']}'\">Submit New Paper</button>
                        </td>
                        <td> 
                            <button onclick=\"window.location.href='../conference_registrations/conf_reg.php?id={$conference['conference_id']}&name={$conference['conference_name']}'\">Join the conference now!</button>
                        </td>
                        ";
                
                
                foreach ($conference as $value) {
                    echo "<td>$value</td>";
                }
                
                echo "</tr>";
            }
            echo '<br>';
            ?>
        </table>
        
    </div></div>

    <?php include '../footer.php'?>
</body>
</html>
