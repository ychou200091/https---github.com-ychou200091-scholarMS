<?php
  
  
try {
    require_once "../includes/dbh.inc.php"; // Include database connection file
    require_once "../includes/config.php";
    // Check if paper_id is provided in the URL
    if (isset($_GET["paper_id"])) {
        // Retrieve paper_id from the URL parameter
        $paper_id = $_GET["paper_id"];
        echo "paper_id: {$paper_id}";
        

        // Query database to fetch paper information based on paper ID
        $query = "SELECT * FROM papers WHERE paper_id = :paper_id";
        $stmt = $pd0->prepare($query);
        $stmt->bindParam(":paper_id", $paper_id, PDO::PARAM_INT);
        $stmt->execute();
        $paper = $stmt->fetch(PDO::FETCH_ASSOC);
        
        
        // Check if paper information is found
        if (!$paper) {
            $_SESSION["user_message"] = "Paper not found.";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        }
        // if accepted or rejected, you can't delete
        if($paper['review_status'] = 'Accepted' ||$paper['review_status'] = 'Rejected'){
            $_SESSION["user_message"] = "Paper status unchangable, unable to delete.";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        }


        // Delete paper file from the "/paper_management" folder
        $file_path = $paper['file_path'];
        $current_directory = $_SERVER['DOCUMENT_ROOT']; //server_directory
        $full_file_path = $current_directory .$file_path; // Destination file path
        if (file_exists($full_file_path)) {
            if(!unlink($full_file_path)){
                echo "Paper delete failed.";
                exit;
            }
        }else{
            echo "file doesn't exist";
            exit;
        }

        // Delete paper from the database
        $query = "DELETE FROM papers WHERE paper_id = :paper_id";
        $stmt = $pd0->prepare($query);
        $stmt->bindParam(":paper_id", $paper_id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect to paper_management.php with success message
        $_SESSION["user_message"] = "Paper deleted successfully.";
        header("Location: paper_management.php");
        exit;
    } else {
        // If paper_id is not provided in the URL, redirect back to the previous page
        $_SESSION["user_message"] = "Paper ID is missing.";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }
} catch (PDOException $e) {
    // If an error occurs, display error message and redirect back to the previous page
    $_SESSION["user_message"] = "Error: " . $e->getMessage();
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}
