<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Include database connection
        require_once "../includes/dbh.inc.php";
        // Get form data
        $paper_id = $_POST["paper_id"];
        $review_status = $_POST["review_status"];
        echo "paper_id :{$paper_id } <br>";
        echo "review_status :{$review_status } <br>";
        
        // Update review status in the database
        $query = "UPDATE papers SET review_status = :review_status WHERE paper_id = :paper_id";
        $stmt = $pd0->prepare($query);
        $stmt->bindParam(':review_status', $review_status);
        $stmt->bindParam(':paper_id', $paper_id);
        $stmt->execute();


        // EMAIL user for status changes
        // send email to user
        // 1. get user email
        // 2. get conference name and paper due date
        // 3. mail paper related info 
        $user_id = $_POST["user_id"];
        require_once "../dbs_phpmailer/func_sendemail_sample.php";
        $sql = "SELECT user_id, email FROM users WHERE user_id = :userID";
        $stmt = $pd0->prepare($sql);
        $stmt->bindParam(':userID',$user_id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // Check if a user was found
        if ($user) {
            echo "User ID: " . $user['user_id'] . "<br>";
            echo "Email: " . $user['email'] . "<br>";
        } else {
            echo "User not found.";
            echo "User id {$user_id}.";
            exit;
        }
          
        $sql = "SELECT p.title AS paper_title, p.review_status, c.conference_name, c.paper_due_date 
                FROM papers p 
                INNER JOIN conferences c ON p.conference_id = c.conference_id 
                WHERE p.paper_id = :paperID";
    
        $stmt = $pd0->prepare($sql);
        $stmt->bindParam(':paperID', $paper_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $review_status  = $result['review_status'];
            $conference_name  = $result['conference_name'];
            $paper_due_date  = $result['paper_due_date'];
            $paper_title  = $result['paper_title'];
            echo "paper_title : " . $result['paper_title'] . "<br>";
            echo "Conference Name: " . $result['conference_name'] . "<br>";
            echo "Paper Due Date: " . $result['paper_due_date'] . "<br>";
            echo "Paper Status: " . $result['paper_status'] . "<br>";
        } else {
            echo "Paper not found.";
        }
        
        $email_sender_email    = "M12304011@nsysu.edu.tw";
        $email_sender_name     = "Scholar MS";
        $email_recipient_email = $user['email'];
        $email_recipient_name  = $_SESSION["username"];
        $email_subject      = "Paper Status Changed";
        $email_body         = "<h2>Paper Status Changed</h2> <br>
                            Paper Title: {$paper_title} <br>
                            Conference Title: {$conference_name} <br>
                            Paper Due date: {$paper_due_date} <br>
                            New Review Status: {$review_status}<br>
                            Have a good time, <br>
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

        // Redirect back to the previous page with success message
        $_SESSION["conf_message"] = "Review status updated successfully.";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    } catch (PDOException $e) {
        // Handle database error
        $_SESSION["conf_message"] = "Error updating review status: " . $e->getMessage();
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }
} else {
    // If the form is not submitted, redirect to the previous page
    $_SESSION["conf_message"] = "not a POST request";
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}
?>
