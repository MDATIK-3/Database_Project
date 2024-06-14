<?php
include 'includes/db.php';

// Fetch departments and exams for dropdowns
$dept_sql = "SELECT Dept_ID, Department_Name FROM Department ORDER BY Department_Name";
$exam_sql = "SELECT Exam_ID, Course_ID FROM Exams ORDER BY Exam_ID"; // Modify as needed

$dept_result = $conn->query($dept_sql);
$exam_result = $conn->query($exam_sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dept_id = $_POST['dept_id'];
    $exam_id = $_POST['exam_id'];

    // Insert new record into Conducts table
    $insert_sql = "INSERT INTO Conducts (Dept_ID, Exam_ID)
                   VALUES ('$dept_id', '$exam_id')";

    if ($conn->query($insert_sql) === TRUE) {
        header("Location: list_conducts.php");
        exit;
    } else {
        echo "Error: " . $insert_sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Conduct Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Add Conduct Record</h1>
        <a href="index.php" class="btn btn-primary mb-3">Back to Home</a>
        <a href="list_conducts.php" class="btn btn-primary mb-3">Back to List</a>

        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="dept_id">Department</label>
                <select class="form-control" id="dept_id" name="dept_id" required>
                    <option value="">Select Department</option>
                    <?php while ($row = $dept_result->fetch_assoc()): ?>
                        <option value="<?php echo $row['Dept_ID']; ?>"><?php echo $row['Department_Name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="exam_id">Exam ID (Course ID)</label>
                <select class="form-control" id="exam_id" name="exam_id" required>
                    <option value="">Select Exam</option>
                    <?php while ($row = $exam_result->fetch_assoc()): ?>
                        <option value="<?php echo $row['Exam_ID']; ?>">
                            <?php echo $row['Exam_ID'] . " (" . $row['Course_ID'] . ")"; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Add Conduct Record</button>
        </form>
    </div>
</body>

</html>