<?php
include 'includes/db.php';

if (isset($_GET['id'])) {
    $schedule_id = $_GET['id'];

    $sql = "DELETE FROM Class_Schedule WHERE Schedule_ID=$schedule_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: schedule.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    header("Location: schedule.php");
}

$conn->close();
?>
