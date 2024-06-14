<?php
include 'includes/db.php';

if (isset($_GET['id'])) {
    $course_id = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $credits = $_POST['credits'];
        $dept_id = $_POST['dept_id'];

        $sql = "UPDATE Course SET 
                C_Name='$name', 
                Description='$description', 
                Credits='$credits', 
                Dept_ID='$dept_id' 
                WHERE Course_ID=$course_id";

        if ($conn->query($sql) === TRUE) {
            header("Location: courses.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $sql = "SELECT * FROM Course WHERE Course_ID=$course_id";
        $result = $conn->query($sql);
        $course = $result->fetch_assoc();
    }
} else {
    header("Location: courses.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Course</h1>
        <a href="courses.php" class="btn btn-primary mb-3">Back to Courses</a>
        
        <form method="POST" action="edit_course.php?id=<?php echo $course_id; ?>">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $course['C_Name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description"><?php echo $course['Description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="credits">Credits</label>
                <input type="number" class="form-control" id="credits" name="credits" value="<?php echo $course['Credits']; ?>" required>
            </div>
            <div class="form-group">
                <label for="dept_id">Department</label>
                <input type="number" class="form-control" id="dept_id" name="dept_id" value="<?php echo $course['Dept_ID']; ?>">
            </div>
            <button type="submit" class="btn btn-warning">Update Course</button>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>
