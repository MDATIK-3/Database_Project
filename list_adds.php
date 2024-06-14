<?php
include 'includes/db.php';

// Fetch all records from Adds table
$sql = "SELECT A.Admin_ID, Ad.Admin_Name, A.Student_ID, S.S_Name, A.Date_Added
        FROM Adds A
        INNER JOIN Administrator Ad ON A.Admin_ID = Ad.Admin_ID
        INNER JOIN Student S ON A.Student_ID = S.Student_ID
        ORDER BY A.Date_Added DESC"; // Modify as needed

$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Added Students</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">List of Added Students</h1>
        <a href="index.php" class="btn btn-primary mb-3">Back to Home</a>
        <a href="add_adds.php" class="btn btn-success mb-3">Add New Record</a>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Admin Name</th>
                    <th>Student Name</th>
                    <th>Date Added</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['Admin_Name']; ?></td>
                        <td><?php echo $row['S_Name']; ?></td>
                        <td><?php echo $row['Date_Added']; ?></td>
                        <td>
                            <a href="edit_adds.php?admin_id=<?php echo $row['Admin_ID']; ?>&student_id=<?php echo $row['Student_ID']; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="delete_adds.php?admin_id=<?php echo $row['Admin_ID']; ?>&student_id=<?php echo $row['Student_ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
