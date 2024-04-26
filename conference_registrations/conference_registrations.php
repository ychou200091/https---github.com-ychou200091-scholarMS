<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit;
}

// Database connection
// Replace with your actual database connection details
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get user's papers
$user_id = $_SESSION['user_id'];
$sql = "SELECT papers.paper_id, papers.title, papers.keywords, conferences.conference_name, conferences.paper_due_date, papers.review_status 
        FROM papers 
        INNER JOIN conferences ON papers.conference_id = conferences.conference_id
        WHERE papers.user_id = $user_id";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paper Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Paper Management</h1>
    </header>
    <nav>
        <a href="#">Select conference and Submit your paper</a>
    </nav>
    <main>
        <h2>Your Papers</h2>
        <ul>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $paper_id = $row['paper_id'];
                $title = $row['title'];
                $keywords = $row['keywords'];
                $conference_name = $row['conference_name'];
                $paper_due_date = $row['paper_due_date'];
                $review_status = $row['review_status'];

                // Check if paper due date is in the past
                $current_date = date('Y-m-d');
                if ($current_date > $paper_due_date) {
                    $disable_edit_delete = true; // Disable edit and delete buttons
                } else {
                    $disable_edit_delete = false;
                }

                // Output paper information
                echo "<li>";
                echo "<strong>Title:</strong> $title<br>";
                echo "<strong>Keywords:</strong> $keywords<br>";
                echo "<strong>Conference:</strong> $conference_name<br>";
                echo "<strong>Due Date:</strong> $paper_due_date<br>";
                echo "<strong>Review Status:</strong> $review_status<br>";
                echo "<button onclick=\"window.location.href='edit_paper.php?paper_id=$paper_id'\" " . ($disable_edit_delete ? "disabled" : "") . ">Edit</button> ";
                echo "<button onclick=\"window.location.href='delete_paper.php?paper_id=$paper_id'\" " . ($disable_edit_delete ? "disabled" : "") . ">Delete</button> ";
                echo "<button onclick=\"window.location.href='download_paper.php?paper_id=$paper_id'\">Download</button>";
                echo "</li>";
            }
        } else {
            echo "You have not submitted any papers yet.";
        }
        ?>
        </ul>
    </main>
    <footer>
        &copy; 2024 All Rights Reserved
    </footer>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
