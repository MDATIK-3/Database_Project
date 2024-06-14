<?php
include 'includes/db.php';

// Fetch administrators and students for dropdowns
$admin_sql = "SELECT Admin_ID, Admin_Name FROM Administrator ORDER BY Admin_Name";
$student_sql = "SELECT Student_ID, S_Name FROM Student ORDER BY S_Name"; // Modify as needed

$admin_result = $conn->query($admin_sql);
$student_result = $conn->query($student_sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = $_POST['admin_id'];
    $student_id = $_POST['student_id'];
    $date_added = $_POST['date_added'];

    // Insert record into Adds table
    $insert_sql = "INSERT INTO Adds (Admin_ID, Student_ID, Date_Added)
                   VALUES ('$admin_id', '$student_id', '$date_added')";

    if ($conn->query($insert_sql) === TRUE) {
        header("Location: list_adds.php");
        exit;
    } else {
        echo "Error adding record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Record to Adds Table</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Add Record to Adds Table</h1>
        <a href="list_adds.php" class="btn btn-primary mb-3">Back to List</a>
        
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="admin_id">Administrator</label>
                <select class="form-control" id="admin_id" name="admin_id" required>
                    <?php while ($admin = $admin_result->fetch_assoc()) : ?>
                        <option value="<?php echo $admin['Admin_ID']; ?>"><?php echo $admin['Admin_Name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="student_id">Student</label>
                <select class="form-control" id="student_id" name="student_id" required>
                    <?php while ($student = $student_result->fetch_assoc()) : ?>
                        <option value="<?php echo $student['Student_ID']; ?>"><?php echo $student['S_Name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="date_added">Date Added</label>
                <input type="date" class="form-control" id="date_added" name="date_added" required>
            </div>
            <button type="submit" class="btn btn-success">Add Record</button>
        </form>
    </div>
</body>
</html>
