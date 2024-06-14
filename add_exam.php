<?php
include 'includes/db.php';

// Define variables and initialize with empty values
$course_id = $exam_date = $max_marks = "";
$course_id_err = $exam_date_err = $max_marks_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate course ID
    if (empty(trim($_POST['course_id']))) {
        $course_id_err = "Please enter the course ID.";
    } else {
        $course_id = trim($_POST['course_id']);
    }

    // Validate exam date
    if (empty(trim($_POST['exam_date']))) {
        $exam_date_err = "Please enter the exam date.";
    } else {
        $exam_date = trim($_POST['exam_date']);
    }

    // Validate max marks
    if (empty(trim($_POST['max_marks']))) {
        $max_marks_err = "Please enter the maximum marks.";
    } else {
        $max_marks = trim($_POST['max_marks']);
    }

    // Check input errors before inserting into database
    if (empty($course_id_err) && empty($exam_date_err) && empty($max_marks_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO Exams (Course_ID, Exam_Date, Max_Marks) VALUES (?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("iss", $param_course_id, $param_exam_date, $param_max_marks);

            // Set parameters
            $param_course_id = $course_id;
            $param_exam_date = $exam_date;
            $param_max_marks = $max_marks;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to exams.php upon successful creation
                header("location: exams.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Exam</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Add Exam</h1>
        <a href="exams.php" class="btn btn-primary mb-3">Back to Exams</a>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group <?php echo (!empty($course_id_err)) ? 'has-error' : ''; ?>">
                <label for="course_id">Course ID</label>
                <input type="number" class="form-control" id="course_id" name="course_id" value="<?php echo htmlspecialchars($course_id); ?>" required>
                <span class="help-block"><?php echo $course_id_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($exam_date_err)) ? 'has-error' : ''; ?>">
                <label for="exam_date">Exam Date</label>
                <input type="date" class="form-control" id="exam_date" name="exam_date" value="<?php echo htmlspecialchars($exam_date); ?>" required>
                <span class="help-block"><?php echo $exam_date_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($max_marks_err)) ? 'has-error' : ''; ?>">
                <label for="max_marks">Max Marks</label>
                <input type="number" class="form-control" id="max_marks" name="max_marks" value="<?php echo htmlspecialchars($max_marks); ?>" required>
                <span class="help-block"><?php echo $max_marks_err; ?></span>
            </div>
            <button type="submit" class="btn btn-success">Add Exam</button>
        </form>
    </div>
</body>
</html>
