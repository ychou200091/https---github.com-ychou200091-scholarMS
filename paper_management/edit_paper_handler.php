<?php



require_once "../includes/dbh.inc.php"; // Include database connection file
require_once "../includes/config.php";
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Retrieve form data
    try {
        echo var_dump($_POST);
        echo "<br>";
        echo var_dump($_FILES);
        echo "<br>";
        
        $paper_id = $_POST["paper_id"];
        $paper_title = $_POST["paperTitle"];
        $authors = $_POST["authors"];
        $keywords = $_POST["keywords"];
        $abstract = $_POST["abstract"];
        $additional_comment = $_POST["additionalComment"];

        // // GET old path of file
        // $query = "SELECT * FROM papers WHERE paper_id = :paper_id";
        // $stmt = $pd0->prepare($query);
        // $stmt->bindParam(":paper_id", $paper_id, PDO::PARAM_INT);
        // $stmt->execute();
        // $paper = $stmt->fetch(PDO::FETCH_ASSOC);
        // $file_path = $paper["file_path"];
        // $old = $paper["file_path"];
        // Check if a new file is uploaded
        
        
        // Query database to fetch paper information based on paper ID
        $query = "SELECT file_path,conference_id FROM papers WHERE paper_id = :paper_id";
        $stmt = $pd0->prepare($query);
        $stmt->bindParam(":paper_id", $paper_id, PDO::PARAM_INT);
        $stmt->execute();
        $paper = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "paper: <br>";
        echo var_dump($paper);
        
        // Check if paper information is found
        if (!$paper) {
            $_SESSION["user_message"] = "Paper not found.";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        }
        $conf_id = $paper["conference_id"];
        $old_file_path = $paper['file_path'];
        $file_path = $paper['file_path'];
        // a new paper is uploaded
        if ($_FILES["file"]["size"] > 0) {
            if (file_exists($old_file_path)) {
                if (!unlink($old_file_path)) { 
                    echo ("$file_pointer cannot be deleted due to an error"); 
                } 
                else { 
                    echo ("$file_pointer has been deleted"); 
                } 
            }else{
                echo "file does not exit<br>";
                echo "<script>console.log('file does not exit');</script>";
            }
            // Delete the old file if it exists
    
            // Move the new file to the paper_management folder
            $file_name = $_FILES["file"]["name"];
            $file_temp = $_FILES["file"]["tmp_name"];
            $file_path = "/paper_management/" . $_SESSION["username"] . "_" . $conf_id . "_" . $paper_title . ".pdf";
            $current_directory = $_SERVER['DOCUMENT_ROOT']; //server_directory
            $full_file_path = $current_directory .$file_path; // Destination file path
            
            echo "<script>console.log('FULL FILE PATH: $full_file_path');</script>";
            echo "<script>console.log('OLD FILE PATH: $old_file_path');</script>";
            echo "<br>FULL FILE PATH: {$full_file_path}<br>";
            echo "OLD FILE PATH: {$old_file_path}<br>";
            echo "file_temp: {$file_temp}<br>";

            
            if(!move_uploaded_file($file_temp, $full_file_path)){
                echo "<script>console.log('File Delete failed');</script>";
                $_SESSION["user_message"] = "File Delete failed";
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit;
            }
            
        } else {
            // Keep the old file path
            $file_path = $paper['file_path'];
        }

        // Update paper information in the database
        $query = "UPDATE papers SET title = :title, authors = :authors, keywords = :keywords, abstract = :abstract, file_path = :file_path, additional_comment = :additional_comment WHERE paper_id = :paper_id";
        $stmt = $pd0->prepare($query);
        $stmt->bindParam(':title', $paper_title);
        $stmt->bindParam(':authors', $authors);
        $stmt->bindParam(':keywords', $keywords);
        $stmt->bindParam(':abstract', $abstract);
        $stmt->bindParam(':file_path', $file_path);
        $stmt->bindParam(':additional_comment', $additional_comment);
        $stmt->bindParam(':paper_id', $paper_id);
        $stmt->execute();

        // Redirect to paper_management.php upon success
        $_SESSION["user_message"] = "*Update Paper Successful*";
        header("Location: paper_management.php");
        exit();
    } catch (PDOException $e) {
        // If an error occurs, display error message and redirect back to the previous page
        $_SESSION["user_message"] = "Error: " . $e->getMessage();
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
}else {
    // If the form is not submitted, redirect back to the previous page
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

?>
