<?php
include 'includes/db.php';

// Check if the ID is set in the URL
if (!isset($_GET['id'])) {
    header("Location: exam_scores.php");
    exit;
}

$score_id = $_GET['id'];

// Fetch the current data
$sql = "SELECT * FROM Exam_Scores WHERE Score_ID = $score_id";
$result = $conn->query($sql);
$score = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_id = $_POST['exam_id'];
    $student_id = $_POST['student_id'];
    $marks_obtained = $_POST['marks_obtained'];

    $sql = "UPDATE Exam_Scores SET Exam_ID = $exam_id, Student_ID = $student_id, Marks_Obtained = $marks_obtained WHERE Score_ID = $score_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: exam_scores.php");
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
    <title>Edit Exam Score</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Exam Score</h1>
        <a href="exam_scores.php" class="btn btn-primary mb-3">Back to Exam Scores</a>
        
        <form method="POST" action="edit_exam_score.php?id=<?php echo $score_id; ?>">
            <div class="form-group">
                <label for="exam_id">Exam ID</label>
                <input type="number" class="form-control" id="exam_id" name="exam_id" value="<?php echo $score['Exam_ID']; ?>" required>
            </div>
            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input type="number" class="form-control" id="student_id" name="student_id" value="<?php echo $score['Student_ID']; ?>" required>
            </div>
            <div class="form-group">
                <label for="marks_obtained">Marks Obtained</label>
                <input type="number" class="form-control" id="marks_obtained" name="marks_obtained" value="<?php echo $score['Marks_Obtained']; ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Update Exam Score</button>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>
