<?php
include 'includes/db.php';

// Retrieve department and exam IDs from the query string
$dept_id = $_GET['dept_id'];
$exam_id = $_GET['exam_id'];

// Delete record from Conducts table
$delete_sql = "DELETE FROM Conducts WHERE Dept_ID = '$dept_id' AND Exam_ID = '$exam_id'";

if ($conn->query($delete_sql) === TRUE) {
    header("Location: list_conducts.php");
    exit;
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
