<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $credits = $_POST['credits'];
    $dept_id = $_POST['dept_id'];

    $sql = "INSERT INTO Course (C_Name, Description, Credits, Dept_ID)
            VALUES ('$name', '$description', '$credits', '$dept_id')";

    if ($conn->query($sql) === TRUE) {
        header("Location: courses.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Add Course</h1>
        <a href="courses.php" class="btn btn-primary mb-3">Back to Courses</a>
        
        <form method="POST" action="add_course.php">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="credits">Credits</label>
                <input type="number" step="0.1" class="form-control" id="credits" name="credits" required>
                </div>
            <div class="form-group">
                <label for="dept_id">Department</label>
                <input type="number" class="form-control" id="dept_id" name="dept_id">
            </div>
            <button type="submit" class="btn btn-success">Add Course</button>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>
