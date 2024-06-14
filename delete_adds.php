<?php
include 'includes/db.php';

// Retrieve admin and student IDs from the query string
$admin_id = $_GET['admin_id'];
$student_id = $_GET['student_id'];

// Delete record from Adds table
$delete_sql = "DELETE FROM Adds WHERE Admin_ID = '$admin_id' AND Student_ID = '$student_id'";

if ($conn->query($delete_sql) === TRUE) {
    header("Location: list_adds.php");
    exit;
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
