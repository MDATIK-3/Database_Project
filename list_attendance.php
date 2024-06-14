<?php
include 'includes/db.php';

$sql = "SELECT * FROM Attendance";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Attendance</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Class Attendance</h1>
        <a href="index.php" class="btn btn-primary mb-3">Back to Home</a>
        <a href="add_attendance.php" class="btn btn-success mb-3">Add Attendance</a>

        <?php
        if ($result->num_rows > 0) {
            echo '<table class="table table-striped">';
            echo '<thead><tr><th>ID</th><th>Date</th><th>Student ID</th><th>Status</th><th>Actions</th></tr></thead><tbody>';
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>{$row['Attendance_ID']}</td><td>{$row['Date']}</td><td>{$row['Student_ID']}</td><td>{$row['Status']}</td>";
                echo "<td><a href='edit_attendance.php?id={$row['Attendance_ID']}' class='btn btn-warning btn-sm'>Edit</a> ";
                echo "<a href='delete_attendance.php?id={$row['Attendance_ID']}' class='btn btn-danger btn-sm'>Delete</a></td></tr>";
            }
            echo '</tbody></table>';
        } else {
            echo "<p>No attendance records found.</p>";
        }
        ?>

    </div>
</body>

</html>

<?php $conn->close(); ?>
