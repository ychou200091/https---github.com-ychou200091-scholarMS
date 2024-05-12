<?php // Check if form is submitted

echo "<p>Here</p>";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo "<p>Here</p>";
    error_reporting(E_ALL);
    

    try {
        require_once "../includes/dbh.inc.php";
        require_once "../includes/config.php";
        // Extract conference ID and name from URL parameters
        $conf_id = $_SESSION["conference_id"];
        $conf_name = $_SESSION["conference_name"];
        $username = $_SESSION["username"];

        // Extract form data
        $authors = $_POST["authors"];
        $title = $_POST["title"];
        $keywords = $_POST["keywords"];
        $abstract = $_POST["abstract"];
        $additional_comment = $_POST["additional_comment"];
        $review_status = 'Not Reviewed';
        $file_name = $_FILES["paper_upload"]["name"];
        $file_temp = $_FILES["paper_upload"]["tmp_name"]; // tmp_file name in server 
        echo "<script>console.log('Debug Objects: " . $file_temp . "' );</script>";
        echo "<p>file_temp:".$file_temp."</p>";
        // Validate file name to prevent weird characters
        if (preg_match('/[^\w\d\s\.\-\(\)]/', $title)) {
            $_SESSION["user_message"] = "*Invalid characters in paper title*";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        }
        echo "<script>console.log('Debug Objects: checked character );</script>";
        // Move uploaded file to destination directory
        $file_path = "/paper_management/" . $username . "_" . $conf_id . "_" . $title . ".pdf";
        //move_uploaded_file($_FILES['paper_upload']['tmp_name'], $file_path);
        $current_directory = $_SERVER['DOCUMENT_ROOT']; //server_directory
        $full_file_path = $current_directory .$file_path; // Destination file path
        echo "File Path: " . $full_file_path . "<br>";
        echo "<script>alert('".$full_file_path. "');</script>";
        echo "<script>alert('".$file_temp. "');</script>";
        
        // Copy the uploaded file to the destination folder
        if (copy($file_temp, $full_file_path)) {
            echo "<br>File copied successfully.<br>";
        } else {
            echo "<br>Failed to copy file.<br>";
        }
        if(!move_uploaded_file($file_temp, $full_file_path)){
            echo "<br>Failed to move file. Error: " . error_get_last()['message'] . "<br>";
             $_SESSION["user_message"] = "File move failed";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        }
        echo "<script>console.log('Debug Objects: file move complete );</script>";
        // Check if a paper with the same title already exists
        $checkQuery = "SELECT COUNT(*) FROM papers WHERE title = :title";
        $checkStmt = $pd0->prepare($checkQuery);
        $checkStmt->bindParam(':title', $title);
        $checkStmt->execute();
        $count = $checkStmt->fetchColumn();

        if ($count > 0) {
            $_SESSION["user_message"] = "*A paper with the same title already exists*";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        }

        // Proceed with insertion if no paper with the same title exists
        $query = "INSERT INTO papers (user_id, conference_id, authors, title, keywords, abstract, file_path, additional_comment, review_status) 
                              VALUES (:user_id, :conf_id, :authors, :title, :keywords, :abstract, :file_path, :additional_comment, :review_status)";
        $stmt = $pd0->prepare($query);
        $stmt->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_INT);
        $stmt->bindParam(':conf_id', $conf_id, PDO::PARAM_INT);
        $stmt->bindParam(':authors', $authors);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':keywords', $keywords);
        $stmt->bindParam(':abstract', $abstract);
        $stmt->bindParam(':file_path', $file_path);
        $stmt->bindParam(':additional_comment', $additional_comment);
        $stmt->bindParam(':review_status', $review_status); // Assuming $review_status contains 'Not Reviewed'
        $stmt->execute();
        // Redirect to previous page with success message
        // ======================================================================
        $_SESSION["user_message"] = "*Paper submitted successfully*";
        // ======================================================================

        // send email to user
        // 1. get user email
        // 2. get conference name and paper due date
        // 3. mail paper related info 
        require_once "../dbs_phpmailer/func_sendemail_sample.php";
        $sql = "SELECT user_id, email FROM users WHERE user_id = :userID";
        $stmt = $pd0->prepare($sql);
        $stmt->bindParam(':userID', $_SESSION["user_id"], PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // Check if a user was found
        if ($user) {
            echo "User ID: " . $user['user_id'] . "<br>";
            echo "Email: " . $user['email'] . "<br>";
        } else {
            echo "User not found.";
            exit;
        }
        
        $sql = "SELECT conference_name, paper_due_date FROM conferences WHERE conference_id = :conferenceID";
        $stmt = $pd0->prepare($sql);
        $stmt->bindParam(':conferenceID', $conf_id, PDO::PARAM_INT);
        $stmt->execute();
        $conference = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($conference) {
            $conference_name=$conference['conference_name'];
            $paper_due_date=$conference['paper_due_date'];
            echo "Conference Name: " . $conference['conference_name'] . "<br>";
            echo "Paper Due Date: " . $conference['paper_due_date'] . "<br>";
        } else {
            echo "Conference not found.";
            exit;
        }
        
        $email_sender_email    = "M12304011@nsysu.edu.tw";
        $email_sender_name     = "Scholar MS";
        $email_recipient_email = $user['email'];
        $email_recipient_name  = $_SESSION["username"];
        $email_subject      = "Paper Submitted Successfully";
        $email_body         = "<h2>Paper Submitted Successfully</h2> <br>
                            Paper Title: {$title} <br>
                            Conference Title: {$conference_name} <br>
                            Paper Due date: {$paper_due_date} <br>
                            Authors: {$authors} <br>
                            Abstract: {$abstract } <br>
                            Thank you for your submission, <br>
                            ScholarMS <br>
                            ";

        $msg = '';
        $status_email = sendemail_sample($email_sender_email, 
                                        $email_sender_name, 
                                        $email_recipient_email, 
                                        $email_recipient_name, 
                                        $email_subject, 
                                        $email_body);
        $msg = '<h2>Email寄送狀態：</h2><p>'.$status_email.'</p>';
        
        echo "<script>console.log('{$msg}' );</script>";

        header("Location: conference_lookup.php");
        unset($_SESSION["conference_id"]);
        unset($_SESSION["conference_name"]);
        unset($stmt);
        exit;
        
    } catch (PDOException $e) {
        $_SESSION["user_message"] = "Error: " . $e->getMessage();
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }
    
}