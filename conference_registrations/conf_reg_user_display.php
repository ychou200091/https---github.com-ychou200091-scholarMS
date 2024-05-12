<?php 
require_once "../includes/config.php";
require_once "../includes/dbh.inc.php";
require_once "../display_user_msg.php";

// echo "user_id".$_SESSION["user_id"] ;
// echo "user_name".$_SESSION["username"];

?>

<?php
// Include database connection file
$user_id = $_SESSION["user_id"]; // Assuming user_id is stored in session

# echo "user_id: " . $user_id;
// Query database for registrations matching the user_id
$query = "SELECT r.user_id, r.first_name, r.last_name, r.email, r.phone_number, r.meal_preference, r.representative_unit, r.registration_date, c.conference_name, c.conference_date
          FROM registrations r
          INNER JOIN conferences c ON r.conference_id = c.conference_id
          WHERE r.user_id = :user_id";
$stmt = $pd0->prepare($query);
$stmt->bindParam(":user_id", $user_id);
$stmt->execute();
$registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display query result in a table
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conference Registrations</title>
    <link rel="stylesheet" href="conf_reg_user_display.css">
    <link rel="stylesheet" href="../bin/header_footer_styles.css">
</head>
<body>
    <?php include '../header.php'; ?>
    <h2>Conference Registrations</h2>
    <div class="container">
    <?php   // Check if the user is logged in and if they are an admin
            if(!isset($_SESSION["username"])):   
    ?>
         <p>*Please login first*</p>
    <?php   // Check if the user is logged in and if they are an admin
            elseif(isset($_SESSION["username"]) && strpos($_SESSION["username"], "admin-") === 0):   
    ?>
            <p>*Please use an user account*</p>
    
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>User Id</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Meal Preference</th>
                    <th>Representative Unit</th>
                    <th>Registration Date</th>
                    <th>Conference Name</th>
                    <th>Conference Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registrations as $registration): ?>
                <tr>
                    <td><?php echo $registration['user_id']; ?></td>
                    <td><?php echo $registration['first_name']; ?></td>
                    <td><?php echo $registration['last_name']; ?></td>
                    <td><?php echo $registration['email']; ?></td>
                    <td><?php echo $registration['phone_number']; ?></td>
                    <td><?php echo $registration['meal_preference']; ?></td>
                    <td><?php echo $registration['representative_unit']; ?></td>
                    <td><?php echo $registration['registration_date']; ?></td>
                    <td><?php echo $registration['conference_name']; ?></td>
                    <td><?php echo $registration['conference_date']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    </div>
    <?php include '../footer.php'; ?>
</body>
</html>
