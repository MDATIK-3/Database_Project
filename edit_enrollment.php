<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $enrollment_date = $_POST['enrollment_date'];

    // Update existing enrollment record
    $update_sql = "UPDATE Enrollment
                   SET Enrollment_Date = '$enrollment_date'
                   WHERE Student_ID = '$student_id' AND Course_ID = '$course_id'";

    if ($conn->query($update_sql) === TRUE) {
        header("Location: list_enrollments.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Fetch enrollment details based on URL parameters
if (isset($_GET['student_id']) && isset($_GET['course_id'])) {
    $student_id = $_GET['student_id'];
    $course_id = $_GET['course_id'];

    // Query to fetch enrollment details
    $enrollment_sql = "SELECT e.Student_ID, s.S_Name, e.Course_ID, c.C_Name, e.Enrollment_Date
                       FROM Enrollment e
                       INNER JOIN Student s ON e.Student_ID = s.Student_ID
                       INNER JOIN Course c ON e.Course_ID = c.Course_ID
                       WHERE e.Student_ID = '$student_id' AND e.Course_ID = '$course_id'";

    $result = $conn->query($enrollment_sql);
    $enrollment = $result->fetch_assoc();

    if (!$enrollment) {
        echo "Enrollment not found.";
        exit;
    }
} else {
    echo "Student ID and Course ID are required.";
    exit;
}

// Fetch students and courses for dropdowns
$student_sql = "SELECT Student_ID, S_Name FROM Student ORDER BY S_Name";
$course_sql = "SELECT Course_ID, C_Name FROM Course ORDER BY C_Name";

$student_result = $conn->query($student_sql);
$course_result = $conn->query($course_sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Enrollment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Enrollment</h1>
        <a href="list_enrollments.php" class="btn btn-primary mb-3">Back to List</a>
        
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="student_id" value="<?php echo $enrollment['Student_ID']; ?>">
            <input type="hidden" name="course_id" value="<?php echo $enrollment['Course_ID']; ?>">
            
            <div class="form-group">
                <label for="student_name">Student Name</label>
                <input type="text" class="form-control" id="student_name" value="<?php echo $enrollment['S_Name']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="course_name">Course Name</label>
                <input type="text" class="form-control" id="course_name" value="<?php echo $enrollment['C_Name']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="enrollment_date">Enrollment Date</label>
                <input type="date" class="form-control" id="enrollment_date" name="enrollment_date" value="<?php echo $enrollment['Enrollment_Date']; ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Update Enrollment</button>
        </form>
    </div>
</body>
</html>
