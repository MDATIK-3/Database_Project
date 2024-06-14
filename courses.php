<?php include 'includes/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Courses</h1>
        <a href="index.php" class="btn btn-primary mb-3">Back to Home</a>
        <a href="add_course.php" class="btn btn-success mb-3">Add Course</a>
        
        <?php
        $sql = "SELECT * FROM Course";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table class="table table-striped">';
            echo '<thead><tr><th>ID</th><th>Name</th><th>Description</th><th>Credits</th><th>Actions</th></tr></thead><tbody>';
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>{$row['Course_ID']}</td><td>{$row['C_Name']}</td><td>{$row['Description']}</td><td>{$row['Credits']}</td>";
                echo "<td><a href='edit_course.php?id={$row['Course_ID']}' class='btn btn-warning btn-sm'>Edit</a> ";
                echo "<a href='delete_course.php?id={$row['Course_ID']}' class='btn btn-danger btn-sm'>Delete</a></td></tr>";
            }
            echo '</tbody></table>';
        } else {
            echo "<p>No courses found.</p>";
        }
        ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>
