<?php include 'includes/db.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Schedule</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Class Schedule</h1>
        <a href="index.php" class="btn btn-primary mb-3">Back to Home</a>
        <a href="add_schedule.php" class="btn btn-success mb-3">Add Schedule</a>

        <?php
        $sql = "SELECT * FROM Class_Schedule";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table class="table table-striped">';
            echo '<thead><tr><th>ID</th><th>Course ID</th><th>Day</th><th>Start Time</th><th>End Time</th><th>Room No</th><th>Actions</th></tr></thead><tbody>';
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>{$row['Schedule_ID']}</td><td>{$row['Course_ID']}</td><td>{$row['Day']}</td><td>{$row['Start_Time']}</td><td>{$row['End_Time']}</td><td>{$row['Room_No']}</td>";
                echo "<td><a href='edit_schedule.php?id={$row['Schedule_ID']}' class='btn btn-warning btn-sm'>Edit</a> ";
                echo "<a href='delete_schedule.php?id={$row['Schedule_ID']}' class='btn btn-danger btn-sm'>Delete</a></td></tr>";
            }
            echo '</tbody></table>';
        } else {
            echo "<p>No schedules found.</p>";
        }
        ?>
    </div>
</body>

</html>

<?php $conn->close(); ?>