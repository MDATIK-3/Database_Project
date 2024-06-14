<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $student_id = $_POST['student_id'];
    $status = $_POST['status'];

    $sql = "INSERT INTO Attendance (Date, Student_ID, Status)
            VALUES ('$date', $student_id, '$status')";

    if ($conn->query($sql) === TRUE) {
        header("Location: list_attendance.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Attendance</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Add Attendance</h1>
        <a href="view_attendance.php" class="btn btn-primary mb-3">Back to Attendance</a>
        
        <form method="POST" action="add_attendance.php">
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input type="number" class="form-control" id="student_id" name="student_id" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                    <option value="Late">Late</option>
                    <option value="Excused">Excused</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Add Attendance</button>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>
