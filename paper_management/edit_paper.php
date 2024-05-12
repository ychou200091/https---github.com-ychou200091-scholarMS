<?php
require_once "../includes/config.php";
require_once "../includes/dbh.inc.php";
require_once "../display_user_msg.php";


// Check if paper ID is set in the URL parameter
if (!isset($_GET["paper_id"])) {
    $_SESSION["user_message"] = "Paper ID not provided.";
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

// Retrieve paper ID from URL parameter
$paper_id = $_GET["paper_id"];

try {
    // Query database to fetch paper information based on paper ID
    $query = "SELECT * FROM papers WHERE paper_id = :paper_id";
    $stmt = $pd0->prepare($query);
    $stmt->bindParam(":paper_id", $paper_id, PDO::PARAM_INT);
    $stmt->execute();
    $paper = $stmt->fetch(PDO::FETCH_ASSOC);
    // echo var_dump($paper);
    // echo "<br>";
    // Check if paper information is found
    if (!$paper) {
        $_SESSION["user_message"] = "Paper not found.";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }
    if($paper["review_status"]=="Accepted"){
        $_SESSION["user_message"] = "Paper is Accepted, unable to edit this paper.";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }
    //$_SESSION["conference_id"] = $paper["conference_id"];
    // check if conference paper due date has passed
    $query = "SELECT conference_id,paper_due_date FROM conferences WHERE conference_id = :conference_id AND paper_due_date >= CURDATE()";
    $stmt = $pd0->prepare($query);
    $stmt->bindParam(":conference_id", $paper["conference_id"], PDO::PARAM_INT);
    $stmt->execute();
    $conf = $stmt->fetch(PDO::FETCH_ASSOC);
    #echo "<br>";
    #echo var_dump($conf);
    if($conf){ // not passed
        #echo var_dump($conf);
    }else{ // time has passed
        $_SESSION["user_message"] = "Paper due date has passed, unable to edit this paper.";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }
    //徵稿截止前，可以持續修改資料及檔案。
    //一旦徵稿截止，若已經審核通過，即無法修改或刪除。
} catch (PDOException $e) {
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
    <title>Edit Paper Information</title>
    <link rel="stylesheet" href="edit_paper.css">
    <link rel="stylesheet" href="../bin/header_footer_styles.css">
</head>
<body>
    <?php include '../header.php'; ?>
    
    <div class="container">
        <h2>Edit Paper Information</h2>
        <form class="form" action="edit_paper_handler.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="paper_id" value="<?php echo $paper['paper_id']; ?>">
            <div class="form-group">
                <label for="paperTitle">Paper Title</label>
                <input type="text" id="paperTitle" name="paperTitle" value="<?php echo $paper['title']; ?>" required>
            </div>
            <div class="form-group">
                <label for="authors">Authors</label>
                <input type="text" id="authors" name="authors" value="<?php echo $paper['authors']; ?>" required>
            </div>
            <div class="form-group">
                <label for="keywords">Keywords</label>
                <input type="text" id="keywords" name="keywords" value="<?php echo $paper['keywords']; ?>" required>
            </div>
            <div class="form-group">
                <label for="abstract">Abstract</label>
                <textarea id="abstract" name="abstract" rows="5" required><?php echo $paper['abstract']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="filePath">File Path</label>
                <input type="file" id="file" name="file" accept=".pdf">
                <a href=<?php echo $paper['file_path']?>> 
                    <button type="button">Download Orginal File</button>
                </a>
                <?php //echo "<p>Current File Path: <?php echo $paper['file_path']</p> ;?>
                
            </div>
            <div class="form-group">
                <label for="additionalComment">Additional Comment</label>
                <textarea id="additionalComment" name="additionalComment" rows="5"><?php echo $paper['additional_comment']; ?></textarea>
            </div>
            
            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
        </form>
        <?php display_message()?>
    </div>
    
    <?php include '../footer.php'; ?>
</body>
</html>
