<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = $_POST['admin_id'];
    $dept_id = $_POST['dept_id'];
    $date_assigned = $_POST['date_assigned'];

    $sql = "UPDATE Manages SET Date_Assigned = ? WHERE Admin_ID = ? AND Dept_ID = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sii", $date_assigned, $admin_id, $dept_id);

        if ($stmt->execute()) {
            header("Location: manages.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}

if (isset($_GET['admin_id']) && isset($_GET['dept_id'])) {
    $admin_id = $_GET['admin_id'];
    $dept_id = $_GET['dept_id'];

    $sql = "SELECT * FROM Manages WHERE Admin_ID = ? AND Dept_ID = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ii", $admin_id, $dept_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $assignment = $result->fetch_assoc();
        $stmt->close();
    }
} else {
    echo "Assignment not specified.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Assignment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Assignment</h1>
        <a href="manages.php" class="btn btn-primary mb-3">Back to Assignments</a>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?admin_id=<?php echo $admin_id; ?>&dept_id=<?php echo $dept_id; ?>">
            <div class="form-group">
                <label for="date_assigned">Date Assigned</label>
                <input type="date" class="form-control" id="date_assigned" name="date_assigned" value="<?php echo $assignment['Date_Assigned']; ?>" required>
            </div>
            <button type="submit" class="btn btn-warning">Update Assignment</button>
        </form>
    </div>
</body>
</html>
