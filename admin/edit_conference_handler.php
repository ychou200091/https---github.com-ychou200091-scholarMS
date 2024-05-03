
<?php
// Start the session
require_once "../includes/config.php";
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');


function sanitizeInput($input) {
    return htmlspecialchars(trim($input));
}
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have already established a database connection
    // Handle form data
    
    $conference_id = $_SESSION["conf_id"];
    $conferenceName = $_POST["conferenceName"];
    $location = $_POST["location"];
    //$callForPapers = ($_POST["callForPapers"] == "yes") ? 1 : 0;
    $callForPapers = $_POST["callForPapers"];
    $conferenceDescription = $_POST["conferenceDescription"];
    $conferenceDate = $_POST["conferenceDate"];
    $paperDueDate = $_POST["paperDueDate"];
    
    try{
        require_once "../includes/dbh.inc.php";
        // Update the database with the new conference information
        
        $query = "UPDATE conferences SET conference_name = :conferenceName, location= :location, call_for_papers = :callForPapers, conference_description = :conferenceDescription, conference_date = :conferenceDate, paper_due_date = :paperDueDate WHERE conference_id = :conferenceId";
        $stmt = $pd0->prepare($query);
        $stmt->bindParam(":conferenceName", $conferenceName);
        $stmt->bindParam(":location", $location);
        $stmt->bindParam(":callForPapers", $callForPapers);
        $stmt->bindParam(":conferenceDescription", $conferenceDescription);
        $stmt->bindParam(":conferenceDate", $conferenceDate);
        $stmt->bindParam(":paperDueDate", $paperDueDate);
        $stmt->bindParam(":conferenceId", $conference_id);

        // Execute the update query
        $result= $stmt->execute();
        // Redirect back to the edit conference page with success message
        $_SESSION["conf_message"] = "Conference information updated successfully.";
        
        header("Location: {$_SERVER['HTTP_REFERER']}");
        $stmt = null;
        die();
        
    }catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        $_SESSION["conf_message"] = $e->getMessage();
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
    
} else {
    // If the form is not submitted via POST method, redirect to the home page
    header("Location: /index.php");
    exit;
}
?>