<?php
include 'includes/db.php';

// Fetch all enrollments
$sql = "SELECT e.Student_ID, s.S_Name, e.Course_ID, c.C_Name, e.Enrollment_Date
        FROM Enrollment e
        INNER JOIN Student s ON e.Student_ID = s.Student_ID
        INNER JOIN Course c ON e.Course_ID = c.Course_ID
        ORDER BY s.S_Name, c.C_Name";

$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Enrollments</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">

        <h1 class="mt-5">List of Enrollments</h1>
        <a href="index.php" class="btn btn-primary mb-3">Go to Home</a>

        <a href="add_enrollment.php" class="btn btn-primary mb-3">Add New Enrollment</a>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Course Name</th>
                    <th>Enrollment Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['S_Name']}</td>";
                        echo "<td>{$row['C_Name']}</td>";
                        echo "<td>{$row['Enrollment_Date']}</td>";
                        echo "<td>";
                        echo "<a href='edit_enrollment.php?student_id={$row['Student_ID']}&course_id={$row['Course_ID']}' class='btn btn-sm btn-primary'>Edit</a> ";
                        echo "<a href='delete_enrollment.php?student_id={$row['Student_ID']}&course_id={$row['Course_ID']}' class='btn btn-sm btn-danger'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No enrollments found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
