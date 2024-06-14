<?php
include 'includes/db.php';

// Check if Attendance_ID parameter exists in URL
if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
    // Prepare SQL statement
    $sql = "DELETE FROM Attendance WHERE Attendance_ID = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("i", $param_attendance_id);

        // Set parameters
        $param_attendance_id = trim($_GET['id']);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to the attendance list page
            header("location: list_attendance.php");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
