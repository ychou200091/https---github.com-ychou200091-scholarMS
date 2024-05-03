<?php


// Include your database connection file here if it's not already included
// require_once 'your_database_connection_file.php';

// Function to sanitize user input
function sanitizeInput($input) {
    return htmlspecialchars(trim($input));
}

// Function to validate date format
function validateDate($date) {
    return (bool)strtotime($date);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate and sanitize form data
    $conferenceName = sanitizeInput($_POST["conferenceName"]);
    $location = sanitizeInput($_POST["location"]);
    $callForPapers = (sanitizeInput($_POST["callForPapers"]) == 'yes') ? 1 : 0;
    $conferenceDescription = sanitizeInput($_POST["conferenceDescription"]);
    $conferenceDate = sanitizeInput($_POST["conferenceDate"]);
    $paperDueDate = sanitizeInput($_POST["paperDueDate"]);

    // Validate date format
    if (!validateDate($conferenceDate) || !validateDate($paperDueDate)) {
        echo "Invalid date format!";
        exit; // Stop execution if date format is invalid
    }

    try {
        // Set up database connection
        require_once("../includes/dbh.inc.php");
        

        // Prepare and execute SQL query to insert data into conferences table
        $query = "INSERT INTO conferences (conference_name, location, call_for_papers, conference_description, conference_date, paper_due_date) 
                  VALUES (:conferenceName, :location, :callForPapers, :conferenceDescription, :conferenceDate, :paperDueDate)";
        $stmt = $pd0->prepare($query);
        $stmt->bindParam(":conferenceName", $conferenceName);
        $stmt->bindParam(":location", $location);
        $stmt->bindParam(":callForPapers", $callForPapers);
        $stmt->bindParam(":conferenceDescription", $conferenceDescription);
        $stmt->bindParam(":conferenceDate", $conferenceDate);
        $stmt->bindParam(":paperDueDate", $paperDueDate);
        $stmt->execute();
        $_SESSION["conf_message"] = "Conference information has been successfully added!";
        
        header("Location: {$_SERVER['HTTP_REFERER']}");
        // Close database connection
        $stmt = null;

        die();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        $_SESSION["conf_message"] = $e->getMessage();
        header("Location: {$_SERVER['HTTP_REFERER']}");
        die();
    }

    
} else {
    $_SESSION["conf_message"] = "Form submission method not allowed!";
    header("Location: {$_SERVER['HTTP_REFERER']}");
}
?>

