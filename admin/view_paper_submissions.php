<?php
    
    //header("Location: {$_SERVER['HTTP_REFERER']}");
    require_once 'display_admin_msg.php';
    require_once "../includes/config.php";
    $_SESSION["conference_id"] = $_GET["id"];
    $_SESSION["conference_name"] = $_GET["name"];
    
    error_reporting(1);
?>

<?php
session_start();

// Include database connection

// Check if conference ID and name are set in session
if(isset($_SESSION["conference_id"]) && isset($_SESSION["conference_name"])) {
    // Retrieve conference ID from session
    $conference_id = $_SESSION["conference_id"];
    try{
        require_once "../includes/dbh.inc.php";
        // Query papers table for papers with the same conference ID
        $query = "SELECT paper_id, user_id, authors, title, keywords, abstract, additional_comment, review_status FROM papers WHERE conference_id = :conference_id";
        $stmt = $pd0->prepare($query);
        $stmt->bindParam(":conference_id", $conference_id);
        $stmt->execute();
        $papers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        $_SESSION["conf_message"] = $e->getMessage();
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
} else {
    // Handle error if conference ID or name is not set in session
    echo "Conference ID or name not provided.";
    exit; // Stop script execution
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScholarMS - View Paper Submissions</title>
    <link rel="stylesheet" href="view_paper_submissions.css">
    <link rel="stylesheet" href="../bin/header_footer_styles.css">
</head>
<body>
    <?php include '../header.php'; ?>
    <div class="container">
        <h1>Conference Papers for <?php echo $_SESSION["conference_name"]; ?></h1>
        <table>
            <thead>
                <tr>
                    <th>Download</th>
                    <th>Paper ID</th>
                    <th>User ID</th>
                    <th>Authors</th>
                    <th>Title</th>
                    <th>Keywords</th>
                    <th>Abstract</th>
                    <th>Additional Comment</th>
                    <th>Review Status</th>
                    <th>Update</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($papers as $paper): ?>
                <tr>
                    <td><button>Download</button></td>
                    <td><?php echo $paper['paper_id']; ?></td>
                    <td><?php echo $paper['user_id']; ?></td>
                    <td><?php echo $paper['authors']; ?></td>
                    <td><?php echo $paper['title']; ?></td>
                    <td><?php echo $paper['keywords']; ?></td>
                    <td><?php echo $paper['abstract']; ?></td>
                    <td><?php echo $paper['additional_comment']; ?></td>
                    <td>
                        <select>
                            <option value="Not Reviewed" <?php if($paper['review_status'] == 'Not Reviewed') echo 'selected'; ?>>Not Reviewed</option>
                            <option value="Under Review" <?php if($paper['review_status'] == 'Under Review') echo 'selected'; ?>>Under Review</option>
                            <option value="Accepted" <?php if($paper['review_status'] == 'Accepted') echo 'selected'; ?>>Accepted</option>
                            <option value="Rejected" <?php if($paper['review_status'] == 'Rejected') echo 'selected'; ?>>Rejected</option>
                        </select>
                    </td>
                    <td><button onclick="updateReviewStatus(<?php echo $paper['paper_id']; ?>)">Update</button></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <?php display_message(); ?>
        </table>
    
        <script>
        function updateReviewStatus(paperId) {
            var selectElement = document.querySelector("select");
            var reviewStatus = selectElement.value;
            <?php $_SESSION["paper_id"] = "' + paperId + '"; ?>
            <?php $_SESSION["review_status"] = "' + reviewStatus + '"; ?>
            window.location.href = "paper_status_update_handler.php";
        }
        </script>
    </div>
    <?php include '../footer.php'?>
</body>
</html>
