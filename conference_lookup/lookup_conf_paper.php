<?php 
require_once "../includes/config.php";
require_once "../includes/dbh.inc.php";
require_once "../display_user_msg.php";

// echo "user_id".$_SESSION["user_id"] ;
// echo "user_name".$_SESSION["username"];

?>
<?php
// Include database connection and configuration files

// Check if conference_id is provided in the GET request
if (!isset($_GET['id'])) {
    echo "Conference ID is missing.";
    exit;
}

// Retrieve conference_id from GET request
$conference_id = $_GET['id'];

// Query database to get all submitted papers for the given conference_id
$query = "SELECT * FROM papers WHERE conference_id = :conference_id";
$stmt = $pd0->prepare($query);
$stmt->bindParam(':conference_id', $conference_id, PDO::PARAM_INT);
$stmt->execute();
$papers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted Papers</title>
    
    <link rel="stylesheet" href="conference_lookup.css">
    <link rel="stylesheet" href="../bin/header_footer_styles.css">
</head>
<body>
    <?php include '../header.php'; ?>
    <h1>Submitted Papers</h1>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Download</th>
                    <th>Title</th>
                    <th>Authors</th>
                    <th>Abstract</th>
                    <th>Review Staus</th>
                    <!-- Add more table headers as needed -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($papers as $paper): ?>
                    <tr>
                        <td><a href="<?php echo $paper['file_path']; ?>" download>Download</a></td>
                        <td><?php echo $paper['title']; ?></td>
                        <td><?php echo $paper['authors']; ?></td>
                        <td><?php echo $paper['abstract']; ?></td>
                        <td><?php echo $paper['review_status']; ?></td>
                        
                        <!-- Add more table cells with paper information -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include '../footer.php'?>
</body>
</html>
