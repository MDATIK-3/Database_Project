<?php
include 'includes/db.php';

if (isset($_GET['admin_id']) && isset($_GET['dept_id'])) {
    $admin_id = $_GET['admin_id'];
    $dept_id = $_GET['dept_id'];

    $sql = "DELETE FROM Manages WHERE Admin_ID = ? AND Dept_ID = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ii", $admin_id, $dept_id);

        if ($stmt->execute()) {
            header("Location: manages.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
} else {
    echo "Assignment not specified.";
    exit;
}
?>
