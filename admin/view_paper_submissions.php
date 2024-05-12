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
        $query = "SELECT * FROM papers WHERE conference_id = :conference_id";
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
                    <td><a href="<?php echo $paper["file_path"]?>"><button >Download</button></a></td>
                    <td><?php echo $paper['paper_id']; ?></td>
                    <td><?php echo $paper['user_id']; ?></td>
                    <td><?php echo $paper['authors']; ?></td>
                    <td><?php echo $paper['title']; ?></td>
                    <td><?php echo $paper['keywords']; ?></td>
                    <td><?php echo $paper['abstract']; ?></td>
                    <td><?php echo $paper['additional_comment']; ?></td>
                    <form action="update_review_status_handler.php" method="post" id="updateForm_<?php echo $paper['paper_id']; ?>">
                        <td>
                            <select name="review_status" id="reviewStatus_<?php echo $paper['paper_id']; ?>">
                                <option value="Not Reviewed" <?php if($paper['review_status'] == 'Not Reviewed') echo 'selected'; ?>>Not Reviewed</option>
                                <option value="Under Review" <?php if($paper['review_status'] == 'Under Review') echo 'selected'; ?>>Under Review</option>
                                <option value="Accepted" <?php if($paper['review_status'] == 'Accepted') echo 'selected'; ?>>Accepted</option>
                                <option value="Rejected" <?php if($paper['review_status'] == 'Rejected') echo 'selected'; ?>>Rejected</option>
                            </select>
                        </td>
                    
                        <td>
                                <input type="hidden" name="paper_id" value="<?php echo $paper['paper_id']; ?>">
                                <input type="hidden" name="user_id" value="<?php echo $paper['user_id']; ?>">
                                <button type="submit" name="update_review_status">Update</button>
                        </td>
                    </form>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <?php display_message(); ?>
        </table>
    
        
    </div>
    <?php include '../footer.php'?>
</body>
</html>
