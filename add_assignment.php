<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = $_POST['admin_id'];
    $dept_id = $_POST['dept_id'];
    $date_assigned = $_POST['date_assigned'];

    $sql = "INSERT INTO Manages (Admin_ID, Dept_ID, Date_Assigned)
            VALUES (?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("iis", $admin_id, $dept_id, $date_assigned);

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Assignment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Add Assignment</h1>
        <a href="index.php" class="btn btn-primary mb-3">Back to Home</a>
        <a href="manages.php" class="btn btn-primary mb-3">Back to Assignments</a>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="admin_id">Admin ID</label>
                <input type="number" class="form-control" id="admin_id" name="admin_id" required>
            </div>
            <div class="form-group">
                <label for="dept_id">Dept ID</label>
                <input type="number" class="form-control" id="dept_id" name="dept_id" required>
            </div>
            <div class="form-group">
                <label for="date_assigned">Date Assigned</label>
                <input type="date" class="form-control" id="date_assigned" name="date_assigned" required>
            </div>
            <button type="submit" class="btn btn-success">Add Assignment</button>
        </form>
    </div>
</body>
</html>
