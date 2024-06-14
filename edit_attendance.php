<?php
include 'includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: view_attendance.php");
    exit;
}

$attendance_id = $_GET['id'];

// Fetch the current data
$sql = "SELECT * FROM Attendance WHERE Attendance_ID = $attendance_id";
$result = $conn->query($sql);
$attendance = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $student_id = $_POST['student_id'];
    $status = $_POST['status'];

    $sql = "UPDATE Attendance SET Date = '$date', Student_ID = $student_id, Status = '$status' WHERE Attendance_ID = $attendance_id";

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
    <title>Edit Attendance</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Attendance</h1>
        <a href="view_attendance.php" class="btn btn-primary mb-3">Back to Attendance</a>
        
        <form method="POST" action="edit_attendance.php?id=<?php echo $attendance_id; ?>">
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date" value="<?php echo $attendance['Date']; ?>" required>
            </div>
            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input type="number" class="form-control" id="student_id" name="student_id" value="<?php echo $attendance['Student_ID']; ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Present" <?php if ($attendance['Status'] == 'Present') echo 'selected'; ?>>Present</option>
                    <option value="Absent" <?php if ($attendance['Status'] == 'Absent') echo 'selected'; ?>>Absent</option>
                    <option value="Late" <?php if ($attendance['Status'] == 'Late') echo 'selected'; ?>>Late</option>
                    <option value="Excused" <?php if ($attendance['Status'] == 'Excused') echo 'selected'; ?>>Excused</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Update Attendance</button>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>
