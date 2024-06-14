<?php
include 'includes/db.php';

$sql = "SELECT ES.Score_ID, ES.Exam_ID, C.Course_ID, C.C_Name, S.Student_ID, S.S_Name, ES.Marks_Obtained
        FROM Exam_Scores ES
        JOIN Exams E ON ES.Exam_ID = E.Exam_ID
        JOIN Course C ON E.Course_ID = C.Course_ID
        JOIN Student S ON ES.Student_ID = S.Student_ID
        ORDER BY E.Exam_Date DESC, S.S_Name";

$result = $conn->query($sql);

// Check if there are any errors in executing the SQL query
if (!$result) {
    die("Error retrieving exam scores: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Scores</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Exam Scores</h1>
        <a href="index.php" class="btn btn-primary mb-3">Back to Home</a>
        <a href="add_exam_score.php" class="btn btn-success mb-3">Add Exam Score</a>
        
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Score ID</th>
                        <th>Exam ID</th>
                        <th>Course ID</th>
                        <th>Course Name</th>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Marks Obtained</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['Score_ID']; ?></td>
                            <td><?php echo $row['Exam_ID']; ?></td>
                            <td><?php echo $row['Course_ID']; ?></td>
                            <td><?php echo $row['C_Name']; ?></td>
                            <td><?php echo $row['Student_ID']; ?></td>
                            <td><?php echo $row['S_Name']; ?></td>
                            <td><?php echo $row['Marks_Obtained']; ?></td>
                            <td>
                                <a href="edit_exam_score.php?id=<?php echo $row['Score_ID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_exam_score.php?id=<?php echo $row['Score_ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this score?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No exam scores found.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>
