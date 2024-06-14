<?php
include 'includes/db.php';

if (isset($_GET['id'])) {
    $admin_id = $_GET['id'];

    $sql = "DELETE FROM Administrator WHERE Admin_ID=$admin_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: administrators.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    header("Location: administrators.php");
}

$conn->close();
?>
