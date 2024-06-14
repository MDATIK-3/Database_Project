<?php
include 'includes/db.php';

// Fetch all conduct records
$conducts_sql = "SELECT c.Dept_ID, d.Department_Name, c.Exam_ID, e.Course_ID
                 FROM Conducts c
                 INNER JOIN Department d ON c.Dept_ID = d.Dept_ID
                 INNER JOIN Exams e ON c.Exam_ID = e.Exam_ID
                 ORDER BY d.Department_Name, e.Exam_ID";

$result = $conn->query($conducts_sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Conduct Records</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">List Conduct Records</h1>
        <a href="index.php" class="btn btn-primary mb-3">Back to Home</a>
        <a href="add_conduct.php" class="btn btn-primary mb-3">Add New Conduct Record</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Department Name</th>
                    <th>Exam ID (Course ID)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['Department_Name']; ?></td>
                        <td><?php echo $row['Exam_ID'] . " (" . $row['Course_ID'] . ")"; ?></td>
                        <td>
                            <a href="edit_conduct.php?dept_id=<?php echo $row['Dept_ID']; ?>&exam_id=<?php echo $row['Exam_ID']; ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="delete_conduct.php?dept_id=<?php echo $row['Dept_ID']; ?>&exam_id=<?php echo $row['Exam_ID']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
