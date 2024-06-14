<?php
include 'includes/db.php';

if (isset($_GET['id'])) {
    $dept_id = $_GET['id'];

    $sql = "DELETE FROM Department WHERE Dept_ID=$dept_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: departments.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    header("Location: departments.php");
}

$conn->close();
?>
