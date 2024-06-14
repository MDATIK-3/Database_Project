<?php
include 'includes/db.php';

$sql = "SELECT m.Admin_ID, m.Dept_ID, m.Date_Assigned, a.Admin_Name, d.Department_Name 
        FROM Manages m 
        JOIN Administrator a ON m.Admin_ID = a.Admin_ID 
        JOIN Department d ON m.Dept_ID = d.Dept_ID";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Assignments</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Manage Assignments</h1>
        <a href="add_assignment.php" class="btn btn-success mb-3">Add Assignment</a>
        
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Admin ID</th>
                        <th>Admin Name</th>
                        <th>Dept ID</th>
                        <th>Department Name</th>
                        <th>Date Assigned</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['Admin_ID']; ?></td>
                            <td><?php echo $row['Admin_Name']; ?></td>
                            <td><?php echo $row['Dept_ID']; ?></td>
                            <td><?php echo $row['Department_Name']; ?></td>
                            <td><?php echo $row['Date_Assigned']; ?></td>
                            <td>
                                <a href="edit_assignment.php?admin_id=<?php echo $row['Admin_ID']; ?>&dept_id=<?php echo $row['Dept_ID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_assignment.php?admin_id=<?php echo $row['Admin_ID']; ?>&dept_id=<?php echo $row['Dept_ID']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No assignments found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php $conn->close(); ?>
