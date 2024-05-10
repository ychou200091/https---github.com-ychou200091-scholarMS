<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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