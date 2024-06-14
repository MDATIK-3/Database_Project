<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $enrollment_date = $_POST['enrollment_date'];

    // Insert new enrollment record
    $insert_sql = "INSERT INTO Enrollment (Student_ID, Course_ID, Enrollment_Date)
                   VALUES ('$student_id', '$course_id', '$enrollment_date')";

    if ($conn->query($insert_sql) === TRUE) {
        header("Location: list_enrollments.php");
        exit;
    } else {
        echo "Error: " . $insert_sql . "<br>" . $conn->error;
    }
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
    <title>Add Enrollment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Add New Enrollment</h1>
        <a href="list_enrollments.php" class="btn btn-primary mb-3">Back to List</a>
        
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="student_id">Student</label>
                <select class="form-control" id="student_id" name="student_id" required>
                    <option value="">Select Student</option>
                    <?php
                    if ($student_result->num_rows > 0) {
                        while ($student = $student_result->fetch_assoc()) {
                            echo "<option value='{$student['Student_ID']}'>{$student['S_Name']}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="course_id">Course</label>
                <select class="form-control" id="course_id" name="course_id" required>
                    <option value="">Select Course</option>
                    <?php
                    if ($course_result->num_rows > 0) {
                        while ($course = $course_result->fetch_assoc()) {
                            echo "<option value='{$course['Course_ID']}'>{$course['C_Name']}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="enrollment_date">Enrollment Date</label>
                <input type="date" class="form-control" id="enrollment_date" name="enrollment_date" required>
            </div>
            <button type="submit" class="btn btn-success">Save Enrollment</button>
        </form>
    </div>
</body>
</html>
