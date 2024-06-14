<?php include 'includes/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrators</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Administrators</h1>
        <a href="index.php" class="btn btn-primary mb-3">Back to Home</a>
        <a href="add_administrator.php" class="btn btn-success mb-3">Add Administrator</a>
        
        <?php
        $sql = "SELECT * FROM Administrator";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table class="table table-striped">';
            echo '<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Contact No</th><th>Date Joined</th><th>Actions</th></tr></thead><tbody>';
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>{$row['Admin_ID']}</td><td>{$row['Admin_Name']}</td><td>{$row['Email']}</td><td>{$row['Contact_No']}</td><td>{$row['Date_Joined']}</td>";
                echo "<td><a href='edit_administrator.php?id={$row['Admin_ID']}' class='btn btn-warning btn-sm'>Edit</a> ";
                echo "<a href='delete_administrator.php?id={$row['Admin_ID']}' class='btn btn-danger btn-sm'>Delete</a></td></tr>";
            }
            echo '</tbody></table>';
        } else {
            echo "<p>No administrators found.</p>";
        }
        ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>
