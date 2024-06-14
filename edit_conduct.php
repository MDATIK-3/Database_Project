<?php
include 'includes/db.php';

// Fetch departments and exams for dropdowns
$dept_sql = "SELECT Dept_ID, Department_Name FROM Department ORDER BY Department_Name";
$exam_sql = "SELECT Exam_ID, Course_ID FROM Exams ORDER BY Exam_ID"; // Modify as needed

$dept_result = $conn->query($dept_sql);
$exam_result = $conn->query($exam_sql);

// Retrieve department and exam IDs from the query string
$dept_id = $_GET['dept_id'];
$exam_id = $_GET['exam_id'];

// Fetch current details of the conduct record
$select_sql = "SELECT Dept_ID, Exam_ID FROM Conducts WHERE Dept_ID = '$dept_id' AND Exam_ID = '$exam_id'";
$result = $conn->query($select_sql);
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_dept_id = $_POST['dept_id'];
    $new_exam_id = $_POST['exam_id'];

    // Update record in Conducts table
    $update_sql = "UPDATE Conducts
                   SET Dept_ID = '$new_dept_id', Exam_ID = '$new_exam_id'
                   WHERE Dept_ID = '$dept_id' AND Exam_ID = '$exam_id'";

    if ($conn->query($update_sql) === TRUE) {
        header("Location: list_conducts.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Conduct Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Conduct Record</h1>
        <a href="list_conducts.php" class="btn btn-primary mb-3">Back to List</a>
        
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . "?dept_id=$dept_id&exam_id=$exam_id"; ?>">
            <div class="form-group">
                <label for="dept_id">Department</label>
                <select class="form-control" id="dept_id" name="dept_id" required>
                    <?php while ($dept = $dept_result->fetch_assoc()) : ?>
                        <option value="<?php echo $dept['Dept_ID']; ?>" <?php echo ($dept['Dept_ID'] == $row['Dept_ID']) ? 'selected' : ''; ?>>
                            <?php echo $dept['Department_Name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="exam_id">Exam ID (Course ID)</label>
                <select class="form-control" id="exam_id" name="exam_id" required>
                    <?php while ($exam = $exam_result->fetch_assoc()) : ?>
                        <option value="<?php echo $exam['Exam_ID']; ?>" <?php echo ($exam['Exam_ID'] == $row['Exam_ID']) ? 'selected' : ''; ?>>
                            <?php echo $exam['Exam_ID'] . " (" . $exam['Course_ID'] . ")"; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Update Conduct Record</button>
        </form>
    </div>
</body>
</html>
