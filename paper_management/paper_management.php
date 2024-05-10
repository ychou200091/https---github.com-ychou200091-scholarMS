<?php 



require_once "../includes/config.php";
require_once "../includes/dbh.inc.php";
echo "user_id".$_SESSION["user_id"] ;
echo "user_name".$_SESSION["username"];

?>
<?php

require_once "../includes/config.php";
require_once "../includes/dbh.inc.php";

try {
    // Check if user is logged in
    if (!isset($_SESSION["user_id"])) {
        $_SESSION["user_message"] = "Please login first.";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }

    // Query the database to fetch the papers submitted by the logged-in user
    $query = "SELECT papers.paper_id AS paper_id, papers.title AS paper_title, papers.authors as authors, papers.review_status, papers.file_path, conferences.conference_name AS conference_name
              FROM papers
              INNER JOIN conferences ON papers.conference_id = conferences.conference_id
              WHERE papers.user_id = :user_id";
    $stmt = $pd0->prepare($query);
    $stmt->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_INT);
    $stmt->execute();
    $papers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle database error
    $_SESSION["user_message"] = "Error: " . $e->getMessage();
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Submitted Papers</title>
    <link rel="stylesheet" href="paper_management.css">
    <link rel="stylesheet" href="../bin/header_footer_styles.css">
</head>
<body>
    <?php include '../header.php'; ?>
    
    <div class="container">
        <h2>Your Submitted Papers</h2>
        <?php if (empty($papers)): ?>
            <p>No papers submitted yet.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Conference Name</th>
                        <th>Paper Title</th>
                        <th>Authors</th>
                        <th>Review Status</th>
                        <th>Edit</th>
                        <th>Download</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($papers as $paper): ?>
                        <tr>
                            <td><?php echo $paper['conference_name']; ?></td>
                            <td><?php echo $paper['paper_title']; ?></td>
                            <td><?php echo $paper['authors']; ?></td>
                            <td><?php echo $paper['review_status']; ?></td>
                            <td>
                                <a href="edit_paper.php?paper_id=<?php echo $paper['paper_id']; ?>&user_id=<?php echo $_SESSION['user_id']; ?>&conf_id=<?php echo $paper['conference_id']; ?>">Edit</a>
                            </td>
                            <td>
                                <a href="<?php echo $paper['file_path']; ?>" download>Download</a>
                            </td>
                            <td>
                                <a href="delete_paper.php?paper_id=<?php echo $paper['paper_id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    
    <?php include '../footer.php'; ?>
</body>
</html>
