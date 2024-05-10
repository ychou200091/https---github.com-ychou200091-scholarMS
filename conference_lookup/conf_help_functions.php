<?php

ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/error.log');
error_reporting(E_ALL);
// Function to check if conference accepts paper submissions
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
function can_conf_submit_paper($conference_id) {
    $host = "localhost";
    $dbname = "scholarMS";
    $dsn = "mysql:host={$host};dbname={$dbname}";
    $dbusername = "root";
    $dbpass = "";
    try {
        $pd0 = new PDO($dsn, $dbusername, $dbpass);
        $pd0->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $query = ("SELECT conference_id,paper_due_date FROM conferences WHERE conference_id = :conference_id;");
        $stmt = $pd0 -> prepare($query);
        $stmt->bindParam(":conference_id", $conference_id);
        $stmt->execute();
        $conference = $stmt->fetch(PDO::FETCH_ASSOC);
        //debug_to_console($conference);
        //$_SESSION["user_message"] =  implode(", ", $conference)."*This conference does not accept new paper submission*";
        if ($conference) {
            
            $paper_due_date = strtotime($conference['paper_due_date']);
            debug_to_console("Paper due date: {$paper_due_date}");
            $current_date = strtotime(date('y-m-d'),time());
            debug_to_console("current_date: {$current_date}");
            
            return $current_date <= $paper_due_date;
        }
        return false;

    } catch (PDOException $e) {
        $_SESSION["user_message"] = $e->getMessage();
        return false;
    }
}




?>