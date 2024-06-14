<?php include 'includes/db.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exams</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Exams</h1>
        <a href="index.php" class="btn btn-primary mb-3">Back to Home</a>
        <a href="add_exam.php" class="btn btn-success mb-3">Add Exam</a>

        <?php
        $sql = "SELECT Exams.Exam_ID, Exams.Exam_Date, Exams.Max_Marks, Course.C_Name FROM Exams
                JOIN Course ON Exams.Course_ID = Course.Course_ID";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table class="table table-striped">';
            echo '<thead><tr><th>Exam ID</th><th>Exam Date</th><th>Max Marks</th><th>Course Name</th><th>Actions</th></tr></thead><tbody>';
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>{$row['Exam_ID']}</td><td>{$row['Exam_Date']}</td><td>{$row['Max_Marks']}</td><td>{$row['C_Name']}</td>";
                echo "<td><a href='edit_exam.php?id={$row['Exam_ID']}' class='btn btn-warning btn-sm'>Edit</a> ";
                echo "<a href='delete_exam.php?id={$row['Exam_ID']}' class='btn btn-danger btn-sm'>Delete</a></td></tr>";
            }
            echo '</tbody></table>';
        } else {
            echo "<p>No exams found.</p>";
        }
        ?>
    </div>
</body>

</html>

<?php $conn->close(); ?>