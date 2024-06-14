<?php
include 'includes/db.php';

if (isset($_GET['id'])) {
    $receipt_no = $_GET['id'];

    $sql = "DELETE FROM Fees WHERE Receipt_No=$receipt_no";

    if ($conn->query($sql) === TRUE) {
        header("Location: fees.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    header("Location: fees.php");
}

$conn->close();
?>
