<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_id = $_POST['exam_id'];
    $student_id = $_POST['student_id'];
    $marks_obtained = $_POST['marks_obtained'];

    // Step 1: Retrieve Max_Marks from Exams table for the given Exam_ID
    $sql_max_marks = "SELECT Max_Marks FROM Exams WHERE Exam_ID = ?";
    $stmt_max_marks = $conn->prepare($sql_max_marks);
    $stmt_max_marks->bind_param("i", $exam_id);
    $stmt_max_marks->execute();
    $result_max_marks = $stmt_max_marks->get_result();

    if ($result_max_marks->num_rows > 0) {
        $row = $result_max_marks->fetch_assoc();
        $max_marks = $row['Max_Marks'];

        // Step 2: Validate Marks_Obtained against Max_Marks
        if ($marks_obtained <= $max_marks) {
            // Step 3: Insert into Exam_Scores table
            $sql_insert = "INSERT INTO Exam_Scores (Exam_ID, Student_ID, Marks_Obtained)
                           VALUES (?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("iii", $exam_id, $student_id, $marks_obtained);

            if ($stmt_insert->execute()) {
                header("Location: exam_scores.php");
                exit();
            } else {
                echo "Error inserting record: " . $stmt_insert->error;
            }
        } else {
            // Marks Obtained is greater than Max Marks, show alert
            echo "<script>alert('Error: Marks Obtained cannot be greater than Max Marks ($max_marks) for this exam.');</script>";
        }
    } else {
        echo "Error: Exam ID not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Exam Score</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Add Exam Score</h1>
        <a href="exam_scores.php" class="btn btn-primary mb-3">Back to Exam Scores</a>

        <form method="POST" action="add_exam_score.php">
            <div class="form-group">
                <label for="exam_id">Exam ID</label>
                <input type="number" class="form-control" id="exam_id" name="exam_id" required>
            </div>
            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input type="number" class="form-control" id="student_id" name="student_id" required>
            </div>
            <div class="form-group">
                <label for="marks_obtained">Marks Obtained</label>
                <input type="number" class="form-control" id="marks_obtained" name="marks_obtained" required>
            </div>
            <button type="submit" class="btn btn-success">Add Exam Score</button>
        </form>
    </div>
</body>

</html>

<?php $conn->close(); ?>