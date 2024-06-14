<?php
// Step 1: Establish database connection
include 'includes/db.php'; // Adjust the path as per your project structure

// Step 2: Validate and sanitize input
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Score ID is required");
}

$score_id = intval($_GET['id']); // Sanitize input to prevent SQL injection

// Step 3: Delete exam score
try {
    $sql_delete = "DELETE FROM Exam_Scores WHERE Score_ID = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $score_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Exam score with ID $score_id deleted successfully!";
        // Optionally redirect to exam scores page or handle UI update
    } else {
        echo "No exam score found with ID $score_id";
    }
} catch (mysqli_sql_exception $e) {
    echo "Error deleting exam score: " . $e->getMessage();
}

// Step 4: Close database connection
$stmt->close();
$conn->close();
?>
