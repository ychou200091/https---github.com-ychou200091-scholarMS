<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {


    try {
        require_once "../includes/dbh.inc.php";
        require_once "../includes/config.php";
        
        // Meta data
        $user_id = $_SESSION["user_id"];
        $conf_id = $_SESSION["conf_id"];
        // Extract form data
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email = $_POST["email"];
        $phone_number = $_POST["phone_number"];
        $meal_preference = $_POST["meal_preference"];
        $representative_unit = $_POST["representative_unit"];
        $registration_date = date("Y-m-d");

        echo "user_id:". $user_id ."<br>" ;
        echo "conf_id:". $conf_id ."<br>" ;
        echo "first_name:". $first_name ."<br>" ;
        echo "last_name:". $last_name ."<br>" ;
        echo "email". $email ."<br>" ;
        echo "phone_number". $phone_number ."<br>" ;
        echo "meal_preference". $meal_preference ."<br>" ;
        echo "representative_unit". $representative_unit ."<br>" ;
        echo "registration_date". $registration_date ."<br>" ;

        // Insert registration information into database
        $query = "INSERT INTO registrations (user_id,conference_id, first_name, last_name, email, phone_number, meal_preference, representative_unit, registration_date) 
                VALUES (:user_id, :conf_id, :first_name, :last_name, :email, :phone_number, :meal_preference, :representative_unit, :registration_date)";
        $stmt = $pd0->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":conf_id", $conf_id);
        $stmt->bindParam(":first_name", $first_name);
        $stmt->bindParam(":last_name", $last_name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone_number", $phone_number);
        $stmt->bindParam(":meal_preference", $meal_preference);
        $stmt->bindParam(":representative_unit", $representative_unit);
        $stmt->bindParam(":registration_date", $registration_date);
        $stmt->execute();
        
        // ======================================
        // Send Email to confirm registration
        require_once "../dbs_phpmailer/func_sendemail_sample.php";
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
        $email_recipient_email = $email;
        $email_recipient_name  = $_SESSION["username"];
        $email_subject      = "Registration Submitted Successfully";
        $email_body         = "<h2>Registration Submitted Successfully</h2> <br>
                            Conference Title: {$conference_name} <br>
                            Last Name: {$last_name} <br>
                            First Name: {$first_name} <br>
                            Email: {$email} <br>
                            Phone Number: {$phone_number} <br>
                            Meal Preference: {$meal_preference} <br>
                            Representative Unit: {$representative_unit} <br>
                            Registration Date: {$registration_date} <br>
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
        // Redirect to previous page with success message
        $_SESSION["user_message"] = "Registration submitted successfully.";
        header("Location:  ../conference_lookup/conference_lookup.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION["user_message"] = "Error: " . $e->getMessage();
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }
}