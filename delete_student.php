<?php
include 'includes/db.php';

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    $sql = "DELETE FROM Student WHERE Student_ID=$student_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: students.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    header("Location: students.php");
}

$conn->close();
?>
