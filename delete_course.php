<?php
include 'includes/db.php';

if (isset($_GET['id'])) {
    $course_id = $_GET['id'];

    $sql = "DELETE FROM Course WHERE Course_ID=$course_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: courses.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    header("Location: courses.php");
}

$conn->close();
?>
